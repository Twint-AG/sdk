// Container build job definition. Kept in its own file so that `just
// container-checksum` can hash only this file (plus the actual image inputs)
// to decide when cached images become stale — changes to ci/pipeline.jsonnet
// orchestration shouldn't invalidate the image cache.
function(php, ssl, imageTag, base) base {
  stage: 'build',
  image: 'quay.io/podman/stable:v5.8.2-immutable@sha256:766815d247ce0edfd8774770371d293728b0b500a219f35de98b408100f5d412',
  variables: {
    PHP_VERSION: php,
    TWINT_SDK_PHP_CURL_SSL_ENGINE: ssl,
    TWINT_SDK_PHP_IMAGE_CACHE: '$CI_REGISTRY_IMAGE/php',
    STORAGE_DRIVER: 'vfs',
  },
  resource_group: 'container-build-' + php,
  timeout: '2h',
  script: [
    'yum install -y skopeo',
    'podman login -u "$CI_REGISTRY_USER" -p "$CI_REGISTRY_PASSWORD" $CI_REGISTRY',
    'podman login -u "$DOCKER_USER" -p "$DOCKER_TOKEN" docker.io',
    'PHP_BASE_IMAGE=$(cat resources-dev/php/${PHP_VERSION}-${TWINT_SDK_PHP_CURL_SSL_ENGINE})',
    std.join(' ', [
      'podman build',
      '--pull=newer',
      '--build-context php_base_image=docker-image://$PHP_BASE_IMAGE',
      '--cache-from $TWINT_SDK_PHP_IMAGE_CACHE',
      '--cache-to $TWINT_SDK_PHP_IMAGE_CACHE',
      '--env TWINT_SDK_PHP_CURL_SSL_ENGINE=$TWINT_SDK_PHP_CURL_SSL_ENGINE',
      '--label "org.opencontainers.image.title=$CI_PROJECT_TITLE"',
      '--label "org.opencontainers.image.url=$CI_PROJECT_URL"',
      '--label "org.opencontainers.image.created=$CI_JOB_STARTED_AT"',
      '--label "org.opencontainers.image.revision=$CI_COMMIT_SHA"',
      '--label "org.opencontainers.image.version=$CI_COMMIT_REF_NAME"',
      '--tag ' + imageTag,
      '-f Dockerfile',
      '$PWD',
    ]),
    'podman push ' + imageTag,
  ],
}
