MAKEFILE := $(lastword $(MAKEFILE_LIST))
BASE_DIR := $(realpath $(dir $(MAKEFILE)))
SOAP_CONFIG_FILE := $(BASE_DIR)/resources/config/soap.php
SOAP_CLIENT_CLI := $(BASE_DIR)/vendor/bin/soap-client

.PHONY: check codegen codegen-clean

check: codegen
	@echo "Check if codegen changed the generated code"
	git diff --exit-code $(BASE_DIR)/src/Generated

codegen-clean:
	rm -rf $(BASE_DIR)/src/Generated/*

codegen: codegen-clean
	$(SOAP_CLIENT_CLI) generate:types --config $(SOAP_CONFIG_FILE)
	$(SOAP_CLIENT_CLI) generate:client --config $(SOAP_CONFIG_FILE)
    $(SOAP_CLIENT_CLI) generate:classmap --config $(SOAP_CONFIG_FILE)