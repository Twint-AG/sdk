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

MAKEFLAGS += --jobs=32

.PHONY: *

test:
	$(PHPUNIT)

static-analysis:
	$(PHPSTAN)

format:
	$(ECS) --fix

check-format:
	$(ECS)

check: static-analysis test check-format
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
