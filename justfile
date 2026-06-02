default: check

set dotenv-load
set shell := ["bash", "-euo", "pipefail", "-c"]
set script-interpreter := ["bash", "-euo", "pipefail"]

# Directories
base_dir := justfile_directory()
codegen_dir := base_dir / "src/Generated"
docs_dir := base_dir / "resources/docs"
vendor_bin := base_dir / "vendor/bin"

# PHP build config (env var > .env > .env.dist via dotenv)
export TWINT_SDK_PHP_VERSION := env_var_or_default("TWINT_SDK_PHP_VERSION", "8.1")
export TWINT_SDK_PHP_CURL_SSL_ENGINE := env_var_or_default("TWINT_SDK_PHP_CURL_SSL_ENGINE", "openssl")
export TWINT_SDK_PHP_BASE_IMAGE := `cat "resources-dev/php/${TWINT_SDK_PHP_VERSION:-8.1}-${TWINT_SDK_PHP_CURL_SSL_ENGINE:-openssl}"`

# Tools
ecs := "php -d memory_limit=1G " + vendor_bin / "ecs"
ecs_check := ecs + " check --no-progress-bar"
phpstan := vendor_bin / "phpstan --memory-limit=1G --verbose"
soap_cli := vendor_bin / "soap-client"
soap_config := base_dir / "resources/config/soap.php"

retry_staggered := "retry --times 10 --delay 0,1,1,2,3,5,5,5,5,5 --"

# Environment
ci := env_var_or_default("GITLAB_CI", "")
_cdv := env_var_or_default("COMPOSER_DEPENDENCY_VERSION", "")
_is_locked := if _cdv == "lowest" { "" } else if _cdv == "highest" { "" } else { "true" }

# Release
release_host := "github.com"
release_repository := "git@" + release_host + ":Twint-AG/sdk.git"
release_bot_name := "TWINT Release Bot"
release_bot_email := "plugin@twint.ch"

# Testing

[private]
phpunit *args:
    {{ if ci != "" { "TWINT_SDK_TESTS_DESTRUCTIVE=1" } else { "" } }} {{ vendor_bin }}/phpunit {{ args }}

test: phpunit
    {{ vendor_bin }}/coverage-check build/coverage/clover.xml 98
    if [ -n "{{ ci }}" ]; then sed -i "s|${CI_PROJECT_DIR}/||g" build/coverage/cobertura.xml build/junit.xml; fi

test-unit: (phpunit "--testsuite=unit")

test-integration: (phpunit "--testsuite=integration")

test-minimal-runtime:
    composer remove --dev phpro/soap-client
    {{ vendor_bin }}/phpunit --no-coverage

# Static analysis

alias phpstan := static-analysis
[parallel]
static-analysis: static-analysis-src static-analysis-docs

[private]
static-analysis-src:
    {{ phpstan }} --configuration={{ if ci != "" { base_dir / "phpstan.neon" } else { base_dir / "phpstan.dev.neon" } }} {{ if ci != "" { "--error-format=gitlab > build/phpstan-src.json" } else { "" } }}

[private]
static-analysis-docs:
    {{ phpstan }} --configuration={{ base_dir }}/phpstan.docs.neon analyse {{ docs_dir }}/_examples/*.php {{ if ci != "" { "--error-format=gitlab > build/phpstan-docs.json" } else { "" } }}

# Formatting

[parallel]
format: format-src format-docs format-vendor-bundled

[private]
format-src:
    {{ ecs_check }} --fix

[private]
format-docs:
    {{ ecs_check }} --config {{ base_dir }}/ecs.docs.php --fix

[private]
format-vendor-bundled:
    {{ ecs_check }} --config {{ base_dir }}/ecs.vendor-bundled.php --fix

[parallel]
check-format: check-format-docs check-format-src

[private]
check-format-src:
    {{ ecs_check }}

[private]
check-format-docs:
    {{ ecs_check }} --config {{ base_dir }}/ecs.docs.php

# Codegen

[private]
codegen-clean:
    rm -rf {{ codegen_dir }}/*

[private]
codegen-generate-types: codegen-clean
    {{ soap_cli }} generate:types --config {{ soap_config }} --quiet

[private]
codegen-generate-client: codegen-clean
    {{ soap_cli }} generate:client --config {{ soap_config }} --quiet

[private]
codegen-generate-classmap: codegen-clean
    {{ soap_cli }} generate:classmap --config {{ soap_config }} --quiet

[parallel]
codegen: codegen-generate-types codegen-generate-client codegen-generate-classmap
    until {{ ecs_check }} {{ codegen_dir }} >/dev/null; do {{ ecs_check }} --fix {{ codegen_dir }} >/dev/null; done

check-codegen: codegen
    @echo "Check if codegen changed the generated code"
    git diff --exit-code {{ codegen_dir }}

# Bundled dependencies

bundle-dependencies:
    php {{ base_dir }}/tools/bundle-dependencies.php
    just format-vendor-bundled

check-bundled-dependencies: bundle-dependencies
    git diff --exit-code {{ base_dir }}/vendor-bundled

# Combined checks

[parallel, script]
check: static-analysis test check-format check-docs
    if [ "${COMPOSER_DEPENDENCY_VERSION:-}" = "locked" ] || [ -z "${COMPOSER_DEPENDENCY_VERSION:-}" ]; then
        just check-codegen
        just check-bundled-dependencies
    fi
    if [ -n "${GITLAB_CI:-}" ]; then
        just test-minimal-runtime
    fi

[parallel]
quickcheck: static-analysis test-unit check-format && check-codegen

# PHP extensions & container build

php-extensions dev="true":
    jq --arg dev {{ dev }} --raw-output \
        '["zip"] + [ \
          [ \
            .platform + if $dev == "true" then ."platform-dev" | if type == "array" then {} else . end else {} end | to_entries[] \
          ] + \
          [ \
            .packages[] | to_entries[] | select (.key == "require" or ($dev == "true" and .key == "require-dev")) | .value | to_entries \
          ] \
          | flatten[] | select(.key | startswith("ext-")) | .key[4:] \
        ] | sort | unique | join(" ")' \
        < {{ base_dir }}/composer.lock > {{ base_dir }}/php-extensions.txt

[private]
check-php-extensions: php-extensions
    git diff --exit-code {{ base_dir }}/php-extensions.txt

container-checksum:
    echo TWINT_SDK_PHP_IMAGE_BASE=$CI_REGISTRY_IMAGE/php:$(sha3sum resources-dev/php/* php-extensions.txt Dockerfile .gitlab-ci.yml | sha3sum | cut -d " " -f 1) > .docker-env

# Docker compose

start: docker-compose-build
    docker compose up --detach --remove-orphans

stop:
    docker compose down

[private]
docker-compose-build: check-php-extensions
    docker compose build

restart: stop && start

dev: start
    docker compose exec -it php bash

dev-docs: start
    docker compose exec -it sphinx bash

# Documentation

[private]
doc-refs:
    php {{ base_dir }}/tools/doc-refs.php

[private]
check-doc-refs:
    {{ if _is_locked != "" { "php " + base_dir + "/tools/doc-refs.php && git diff --exit-code " + docs_dir } else { ":" } }}

[parallel, script]
check-docs: check-format-docs check-doc-refs static-analysis-docs
    for f in {{ docs_dir }}/_examples/*.example.php; do
        php -l "$f"
        {{ retry_staggered }} php -d auto_prepend_file={{ docs_dir }}/_examples/bootstrap.php "$f" > /dev/null
    done

docs:
    sphinx-build -M html {{ docs_dir }} build/docs -W

# Composer install

install:
    {{ retry_staggered }} {{ if _cdv == "lowest" { "composer update --prefer-lowest" } else if _cdv == "highest" { "composer update" } else { "composer install" } }}

# Wiremock

wiremock-setup:
    php {{ base_dir }}/tools/wiremock-setup.php

# Release

[script]
release:
    echo "Syncing release ${CI_COMMIT_TAG:?CI_COMMIT_TAG must be set}"
    mkdir -p ~/.ssh
    chmod 400 "$TWINT_GITHUB_DEPLOY_KEY"
    ssh-keyscan {{ release_host }} >> ~/.ssh/known_hosts
    GIT_SSH_COMMAND="ssh -i $TWINT_GITHUB_DEPLOY_KEY" git push --force {{ release_repository }} HEAD^:latest "$CI_COMMIT_TAG":"$CI_COMMIT_TAG"

[script]
tag version:
    test "$(git rev-parse --abbrev-ref HEAD)" = develop
    git diff --exit-code
    git diff --exit-code --cached
    git pull origin develop
    sed -e "s@9.9.9-dev@{{ version }}@g" -i {{ base_dir }}/src/SdkVersion.php
    GIT_COMMITTER_NAME="{{ release_bot_name }}" GIT_COMMITTER_EMAIL="{{ release_bot_email }}" GIT_AUTHOR_NAME="{{ release_bot_name }}" GIT_AUTHOR_EMAIL="{{ release_bot_email }}" git commit --no-gpg-sign -m "chore(release-management): bump to {{ version }}" {{ base_dir }}/src/SdkVersion.php
    GIT_COMMITTER_NAME="{{ release_bot_name }}" GIT_COMMITTER_EMAIL="{{ release_bot_email }}" git tag --no-sign -a {{ version }} -m "chore(release-management): tag {{ version }}"
    git reset --hard HEAD^
    [ -z "${DRY_RUN:-}" ] && git push origin {{ version }} || exit 0
