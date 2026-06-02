#!/usr/bin/env bash
# Probes the GitLab container registry for each (PHP, SSL) combo. Emits a
# comma-separated list of "<php>-<ssl>" combos whose image is missing under
# $TWINT_SDK_PHP_IMAGE_BASE. The output feeds ci/pipeline.jsonnet via the
# MISSING_TAGS ext-str. Expects `skopeo` on PATH and a prior `skopeo login`
# against $CI_REGISTRY.

set -euo pipefail

: "${TWINT_SDK_PHP_IMAGE_BASE:?must be set; run \`just container-checksum\` first}"

php_versions=(8.1 8.2 8.3 8.4)
ssl_engines=(openssl nss nss-nobignum gnutls)

missing=()
for php in "${php_versions[@]}"; do
    for ssl in "${ssl_engines[@]}"; do
        image="${TWINT_SDK_PHP_IMAGE_BASE}-${php}-${ssl}"
        if ! skopeo inspect "docker://${image}" >/dev/null 2>&1; then
            missing+=("${php}-${ssl}")
        fi
    done
done

(IFS=','; echo "${missing[*]:-}")
