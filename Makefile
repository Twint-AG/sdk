.DEFAULT_GOAL := check
MAKEFILE := $(lastword $(MAKEFILE_LIST))
BASE_DIR := $(realpath $(dir $(MAKEFILE)))

CODEGEN_DIR := $(BASE_DIR)/src/Generated
VENDOR_BIN_DIR := $(BASE_DIR)/vendor/bin

SOAP_CONFIG := $(BASE_DIR)/resources/config/soap.php
SOAP_CLI := $(VENDOR_BIN_DIR)/soap-client
ECS := $(VENDOR_BIN_DIR)/ecs check --no-progress-bar
PHPUNIT := $(VENDOR_BIN_DIR)/phpunit
PHPSTAN := $(VENDOR_BIN_DIR)/phpstan --memory-limit=1G

DOCKER_COMPOSE = docker compose --env-file $(BASE_DIR)/.env.dist --env-file $(BASE_DIR)/.env

MAKEFLAGS += --jobs=32

.PHONY: *

test:
	$(PHPUNIT)

test-unit:
	$(PHPUNIT) --testsuite=unit

test-integration:
	$(PHPUNIT) --testsuite=integration

static-analysis:
	test $$GITLAB_CI && $(PHPSTAN) --error-format=gitlab > build/phpstan.json || $(PHPSTAN)

format:
	$(ECS) --fix

check-format:
	$(ECS)

check: static-analysis test check-format
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
