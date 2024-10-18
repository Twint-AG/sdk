.DEFAULT_GOAL := check
MAKEFILE := $(lastword $(MAKEFILE_LIST))
BASE_DIR := $(realpath $(dir $(MAKEFILE)))

CODEGEN_DIR := $(BASE_DIR)/src/Generated
DOCS_DIR := $(BASE_DIR)/resources/docs
VENDOR_BIN_DIR := $(BASE_DIR)/vendor/bin
DOC_EXAMPLES := $(wildcard $(DOCS_DIR)/_examples/*.example.php)

SOAP_CONFIG := $(BASE_DIR)/resources/config/soap.php
SOAP_CLI := $(VENDOR_BIN_DIR)/soap-client
ECS := $(VENDOR_BIN_DIR)/ecs check --no-progress-bar
ECS_DOCS := $(ECS) --config $(BASE_DIR)/ecs.docs.php
PHPUNIT := $(VENDOR_BIN_DIR)/phpunit
PHPSTAN := $(VENDOR_BIN_DIR)/phpstan --memory-limit=1G --verbose
PHPSTAN_SRC := $(PHPSTAN) --configuration=$(BASE_DIR)/phpstan.dev.neon
DEV := true

ifdef GITLAB_CI
	PHPSTAN_SRC := $(PHPSTAN) --configuration=$(BASE_DIR)/phpstan.neon --error-format=gitlab > build/phpstan-src.json
endif
PHPSTAN_DOCS := $(PHPSTAN) --configuration=$(BASE_DIR)/phpstan.docs.neon analyse $(DOCS_DIR)/_examples/*.php
ifdef GITLAB_CI
	PHPSTAN_DOCS := $(PHPSTAN_DOCS) --error-format=gitlab > build/phpstan-docs.json
endif

DOCKER_COMPOSE = docker compose --env-file $(BASE_DIR)/.env.dist --env-file $(BASE_DIR)/.env

RELEASE_HOST = github.com
RELEASE_REPOSITORY = git@$(RELEASE_HOST):Twint-AG/sdk.git
RELEASE_BOT_NAME = TWINT Release Bot
RELEASE_BOT_EMAIL = plugin@twint.ch
CI_COMMIT_TAG ?= $(error CI_COMMIT_TAG must be set)
VERSION ?= $(error VERSION must be set)

MAKEFLAGS += --jobs=32

RETRY_INFINITE := retry --delay 0 --
RETRY_STAGGERED := retry --times 5 --delay 1,1,2,3,5 --

.PHONY: * $(DOC_EXAMPLES)

test:
	$(PHPUNIT)

test-unit:
	$(PHPUNIT) --testsuite=unit

test-integration:
	$(PHPUNIT) --testsuite=integration

test-minimal-runtime:
	composer remove --dev phpro/soap-client
	$(PHPUNIT)

phpstan static-analysis: static-analysis-src static-analysis-docs

static-analysis-src:
	$(PHPSTAN_SRC)

static-analysis-docs:
	$(PHPSTAN_DOCS)

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
	$(MAKE) check-minimal-soap
ifdef GITLAB_CI
	$(MAKE) test-minimal-runtime
endif

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
	# Need multiple formatting passes
	$(RETRY_INFINITE) sh -c "$(ECS) --fix $(CODEGEN_DIR) >/dev/null"

check-codegen: codegen
	@echo "Check if codegen changed the generated code"
	git diff --exit-code $(CODEGEN_DIR)

extract-minimal-soap:
	php $(BASE_DIR)/tools/minimal-soap.php

check-minimal-soap: extract-minimal-soap
	git diff --exit-code $(BASE_DIR)/src

QUERY_PHP_EXTENSIONS = ["zip"] + \
[ \
  [ \
	.platform + if $$dev == "true" then ."platform-dev" | if type == "array" then {} else . end else {} end | to_entries[] \
  ] + \
  [ \
	.packages[] | to_entries[] | select (.key == "require" or ($$dev == "true" and .key == "require-dev")) | .value | to_entries \
  ] \
  | flatten[] | select(.key | startswith("ext-")) | .key[4:] \
] | sort | unique | join(" ")

php-extensions:
	jq --arg dev $(DEV) --raw-output '$(QUERY_PHP_EXTENSIONS)' < $(BASE_DIR)/composer.lock > $(BASE_DIR)/php-extensions.txt

check-php-extensions: php-extensions
	git diff --exit-code $(BASE_DIR)/php-extensions.txt

container-checksum: check-php-extensions
	echo TWINT_SDK_PHP_IMAGE_BASE=$$CI_REGISTRY_IMAGE/php:$$(sha3sum php-extensions.txt Dockerfile .gitlab-ci.yml Makefile | sha3sum | cut -d " " -f 1) > .docker-env

wiremock-setup:
	php $(BASE_DIR)/tools/wiremock-setup.php

start: docker-compose-build
	$(DOCKER_COMPOSE) up --detach --remove-orphans

stop:
	$(DOCKER_COMPOSE) down

docker-compose-build: check-php-extensions
	$(DOCKER_COMPOSE) build

restart:
	$(MAKE) stop
	$(MAKE) start

dev: start
	$(DOCKER_COMPOSE) exec -it php bash

dev-docs: start
	$(DOCKER_COMPOSE) exec -it sphinx bash

doc-refs:
	php $(BASE_DIR)/tools/doc-refs.php

check-doc-refs:
	php $(BASE_DIR)/tools/doc-refs.php
	git diff --exit-code $(DOCS_DIR)

check-docs: check-format-docs check-doc-refs static-analysis-docs $(DOC_EXAMPLES)

$(DOC_EXAMPLES):
	php -l $@
	php -d auto_prepend_file=$(DOCS_DIR)/_examples/bootstrap.php $@ > /dev/null

docs:
	sphinx-build -M html $(DOCS_DIR) build/docs -W

install:
ifeq ("${COMPOSER_DEPENDENCY_VERSION}", "lowest")
	$(RETRY_STAGGERED) composer update --prefer-lowest
else ifeq ("${COMPOSER_DEPENDENCY_VERSION}", "highest")
	$(RETRY_STAGGERED) composer update
else
	$(RETRY_STAGGERED) composer install
endif

release:
	echo "Syncing release $(CI_COMMIT_TAG)"
	mkdir -p ~/.ssh
	chmod 400 $(TWINT_GITHUB_DEPLOY_KEY)
	ssh-keyscan $(RELEASE_HOST) >> ~/.ssh/known_hosts
	GIT_SSH_COMMAND="ssh -i $(TWINT_GITHUB_DEPLOY_KEY)" git push --force $(RELEASE_REPOSITORY) HEAD^:latest $(CI_COMMIT_TAG):$(CI_COMMIT_TAG)

tag:
	git diff --exit-code
	git diff --exit-code --cached
	sed -e "s@9.9.9-dev@$(VERSION)@g" -i $(BASE_DIR)/src/SdkVersion.php
	GIT_COMMITTER_NAME="$(RELEASE_BOT_NAME)" GIT_COMMITTER_EMAIL="$(RELEASE_BOT_EMAIL)" GIT_AUTHOR_NAME="$(RELEASE_BOT_NAME)" GIT_AUTHOR_EMAIL="$(RELEASE_BOT_EMAIL)" git commit -m "chore(release-management): bump to $(VERSION)" $(BASE_DIR)/src/SdkVersion.php
	GIT_COMMITTER_NAME="$(RELEASE_BOT_NAME)" GIT_COMMITTER_EMAIL="$(RELEASE_BOT_EMAIL)" git tag --no-sign -a $(VERSION) -m "chore(release-management): tag $(VERSION)"
	git reset --hard HEAD^
	[ -z "$$DRY_RUN" ] && git push origin $(VERSION) || exit 0
