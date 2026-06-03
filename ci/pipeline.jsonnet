local imageBase = std.extVar('TWINT_SDK_PHP_IMAGE_BASE');
local missingTagsRaw = std.extVar('TWINT_SDK_PHP_MISSING_TAGS');
local missingTags =
  if std.length(missingTagsRaw) == 0
  then []
  else std.split(missingTagsRaw, ',');

// The set of (PHP, SSL) build targets is derived from the filenames under
// resources-dev/php/ — that directory is the single source of truth. The
// plan job lists it and passes the result here as a comma-separated string.
local combos = std.split(std.extVar('TWINT_SDK_PHP_VERSIONS'), ',');
local splitCombo(c) = std.splitLimit(c, '-', 1);
local phpVersions = std.set([splitCombo(c)[0] for c in combos]);
local sslEngines = std.set([splitCombo(c)[1] for c in combos]);
local phpVersionsLocked = ['8.1', '8.2'];

local image(php, ssl) = '%s-%s-%s' % [imageBase, php, ssl];
local combo(php, ssl) = '%s-%s' % [php, ssl];
local missing(php, ssl) = std.member(missingTags, combo(php, ssl));
local buildJobName(php, ssl) = 'container-' + combo(php, ssl);
local buildNeed(php, ssl) =
  if missing(php, ssl)
  then [{ job: buildJobName(php, ssl), artifacts: false }]
  else [];

local base = {
  interruptible: true,
  before_script: ['set -euo pipefail'],
  tags: ['d13-runner'],
};

local wiremockService = [{
  name: 'wiremock/wiremock:3x@sha256:fd27e46090916e85326229e5102ee169ae729059f3374549615bd20a35fee1f2',
  alias: 'wiremock',
}];

local containerBuild = import 'container-build.libsonnet';

local envFile = {
  script+: [
    'cp ${TWINT_SDK_CI_DOT_ENV} .env',
    'cat ${TWINT_SDK_CI_CERT} | base64 -d > build/certificate.p12',
  ],
};

// Everything needed to run jobs that exercise the SDK against wiremock:
// the service, the SSL-engine env var, and the local fixture setup.
local fixtures(ssl) = envFile {
  services: wiremockService,
  variables+: { TWINT_SDK_PHP_CURL_SSL_ENGINE: ssl },
  script+: [
    'just wiremock-setup',
  ],
};

local phpJob(php, ssl, dep, stage) = base {
  stage: stage,
  image: image(php, ssl),
  variables: {
    COMPOSER_ALLOW_SUPERUSER: 'true',
    PHP_VERSION: php,
    COMPOSER_DEPENDENCY_VERSION: dep,
  },
  needs: buildNeed(php, ssl),
  script: [
    'mkdir -p build',
    'just install',
  ],
};

local testJob(php, ssl, dep) = phpJob(php, ssl, dep, 'test') + fixtures(ssl) + {
  variables+: { XDEBUG_MODE: 'coverage' },
  script+: [
    'just test',
  ] + (if dep == 'locked' then ['just test-minimal-runtime'] else []),
  coverage: '/Lines:\\s+\\d+(?:\\.\\d+)?%/',
  artifacts: {
    reports: {
      junit: 'build/junit.xml',
      cobertura: 'build/coverage/cobertura.xml',
    },
  },
};

local staticAnalysisJob(php, dep) = phpJob(php, 'openssl', dep, 'check') + {
  script+: [
    'just static-analysis-src',
  ],
  artifacts: {
    reports: {
      codequality: ['build/phpstan-src.json'],
    },
  },
};

local codegenJob(php, dep) = phpJob(php, 'openssl', dep, 'codegen') + {
  script+: [
    'just check-codegen',
    'just check-bundled-dependencies',
  ],
};

local formatAndDocsCheckJob = phpJob('8.1', 'openssl', 'locked', 'check') + envFile + {
  script+: [
    'just check-format',
    'just check-docs',
  ],
};

// Release runs only on tag pipelines. Stage ordering (no explicit `needs:`)
// makes it wait for every job in `build` and `check` — avoids the 50-needs
// limit that previously required a `test-finished` bridge job.
local releaseJob = base {
  stage: 'release',
  interruptible: false,
  image: image('8.3', 'openssl'),
  only: ['tags'],
  variables: { GIT_DEPTH: '0' },
  script: ['just release'],
};

local containerJobs = {
  [buildJobName(php, ssl)]: containerBuild(php, ssl, image(php, ssl), base)
  for php in phpVersions
  for ssl in sslEngines
  if missing(php, ssl)
};

local testJobs =
  {
    ['test-%s-%s-%s' % [php, ssl, dep]]: testJob(php, ssl, dep)
    for php in phpVersions
    for ssl in sslEngines
    for dep in ['lowest', 'highest']
  }
  + {
    ['test-%s-%s-locked' % [php, ssl]]: testJob(php, ssl, 'locked')
    for php in phpVersionsLocked
    for ssl in sslEngines
  };

local staticAnalysisJobs =
  {
    ['static-analysis-%s-highest' % php]: staticAnalysisJob(php, 'highest')
    for php in phpVersions
  }
  + {
    ['static-analysis-%s-locked' % php]: staticAnalysisJob(php, 'locked')
    for php in phpVersionsLocked
  };

local codegenJobs = {
  ['codegen-%s-%s' % [php, dep]]: codegenJob(php, dep)
  for php in phpVersionsLocked
  for dep in ['lowest', 'highest', 'locked']
};

{ stages: ['build', 'test', 'check', 'codegen', 'release'] }
+ containerJobs
+ testJobs
+ staticAnalysisJobs
+ codegenJobs
+ {
  'format-and-docs-check': formatAndDocsCheckJob,
  release: releaseJob,
}
