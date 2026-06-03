#!/usr/bin/env bash
# Probes the GitLab container registry for each (PHP, SSL) combo declared in
# resources-dev/php/. Emits a comma-separated list of "<php>-<ssl>" combos
# whose image is missing under $TWINT_SDK_PHP_IMAGE_BASE. The output feeds
# ci/pipeline.jsonnet via the TWINT_SDK_PHP_MISSING_TAGS ext-str. Expects
# `skopeo` on PATH and a prior `skopeo login` against $CI_REGISTRY.

set -euo pipefail

: "${TWINT_SDK_PHP_IMAGE_BASE:?must be set; run \`just container-checksum\` first}"

missing=()
for f in resources-dev/php/*; do
    combo=$(basename "$f")
    image="${TWINT_SDK_PHP_IMAGE_BASE}-${combo}"
    if ! skopeo inspect "docker://${image}" >/dev/null 2>&1; then
        missing+=("${combo}")
    fi
done

(IFS=','; echo "${missing[*]:-}")
