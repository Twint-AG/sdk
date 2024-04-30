.DEFAULT_GOAL := check
MAKEFILE := $(lastword $(MAKEFILE_LIST))
BASE_DIR := $(realpath $(dir $(MAKEFILE)))

CODEGEN_DIR := $(BASE_DIR)/src/Generated
VENDOR_BIN_DIR := $(BASE_DIR)/vendor/bin
DOC_EXAMPLES := $(wildcard $(BASE_DIR)/resources/docs/_examples/*.example.php)

SOAP_CONFIG := $(BASE_DIR)/resources/config/soap.php
SOAP_CLI := $(VENDOR_BIN_DIR)/soap-client
ECS := $(VENDOR_BIN_DIR)/ecs check --no-progress-bar
ECS_DOCS := $(ECS) --config $(BASE_DIR)/ecs.docs.php
PHPUNIT := $(VENDOR_BIN_DIR)/phpunit
PHPSTAN := $(VENDOR_BIN_DIR)/phpstan --memory-limit=1G
PHPSTAN_DOCS := $(PHPSTAN) --configuration=$(BASE_DIR)/phpstan.docs.neon analyse $(BASE_DIR)/resources/docs/_examples/*.php

DOCKER_COMPOSE = docker compose --env-file $(BASE_DIR)/.env.dist --env-file $(BASE_DIR)/.env

MAKEFLAGS += --jobs=32

.PHONY: * $(DOC_EXAMPLES)

test:
	$(PHPUNIT)

test-unit:
	$(PHPUNIT) --testsuite=unit

test-integration:
	$(PHPUNIT) --testsuite=integration

static-analysis: static-analysis-src static-analysis-docs

static-analysis-src:
	test $$GITLAB_CI && $(PHPSTAN) --error-format=gitlab > build/phpstan-src.json || $(PHPSTAN)

static-analysis-docs:
	test $$GITLAB_CI && $(PHPSTAN_DOCS) --error-format=gitlab > build/phpstan-docs.json || $(PHPSTAN_DOCS)

format: format-src format-docs

format-src:
	$(ECS) --fix

format-docs:
	$(ECS_DOCS) --fix

check-format: check-format-docs check-format-src

check-format-src:
	$(ECS)

check-format-docs:
	$(ECS_DOCS)

check: static-analysis test check-format check-docs
	$(MAKE) check-codegen

quickcheck: static-analysis test-unit check-format
	$(MAKE) check-codegen

codegen-clean:
	rm -rf $(CODEGEN_DIR)/*

codegen-generate-types: codegen-clean
	$(SOAP_CLI) generate:types --config $(SOAP_CONFIG) --quiet

codegen-generate-client: codegen-clean
	$(SOAP_CLI) generate:client --config $(SOAP_CONFIG) --quiet

codegen-generate-classmap: codegen-clean
	$(SOAP_CLI) generate:classmap --config $(SOAP_CONFIG) --quiet

codegen: codegen-generate-types codegen-generate-client codegen-generate-classmap
	$(ECS) --fix $(CODEGEN_DIR) >/dev/null || $(ECS) --fix $(CODEGEN_DIR) >/dev/null || $(ECS) --fix $(CODEGEN_DIR) >/dev/null

check-codegen: codegen
	@echo "Check if codegen changed the generated code"
	git diff --exit-code $(CODEGEN_DIR)

container-checksum:
	echo TWINT_SDK_PHP_IMAGE_BASE=$$CI_REGISTRY_IMAGE/php:$$(sha3sum composer.lock Dockerfile .gitlab-ci.yml Makefile | sha3sum | cut -d " " -f 1) > .docker-env

wiremock-setup:
	php $(BASE_DIR)/tools/wiremock-setup.php

start: docker-compose-build
	$(DOCKER_COMPOSE) up --detach --remove-orphans

stop:
	$(DOCKER_COMPOSE) down

docker-compose-build:
	$(DOCKER_COMPOSE) build

restart:
	$(MAKE) stop
	$(MAKE) start

dev: start
	$(DOCKER_COMPOSE) exec -it php sh

dev-docs: start
	$(DOCKER_COMPOSE) exec -it sphinx bash

check-docs: check-format-docs static-analysis-docs $(DOC_EXAMPLES)

$(DOC_EXAMPLES):
	php -l $@
	php -d auto_prepend_file=$(BASE_DIR)/resources/docs/_examples/bootstrap.php $@ > /dev/null

docs:
	sphinx-build -M html resources/docs build/docs -W

install:
ifeq ("${COMPOSER_DEPENDENCY_VERSION}", "lowest")
	composer update --prefer-lowest
else ifeq ("${COMPOSER_DEPENDENCY_VERSION}", "highest")
	composer update
else
	composer install
endif
