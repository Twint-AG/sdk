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

// The empirical lane is driven by the SSL engine, not by the PHP version. WireMock is served
// over plain HTTP, so these are the only jobs that perform a TLS handshake, and the engine
// decides how the client certificate is handled -- the one axis the hermetic lane cannot
// cover. PHP breadth is already covered there, so each engine borrows a PHP version in
// turn: one job per engine rather than their cross-product, because real-API jobs are
// expensive against PAT.
//
// Iterating engines rather than versions means an engine can never end up without an empirical
// job, however the PHP matrix changes.
local empiricalCombos = [
  { ssl: sslEngines[i], php: phpVersions[i % std.length(phpVersions)] }
  for i in std.range(0, std.length(sslEngines) - 1)
];

// The lock file cannot be installed on every PHP version -- packages in it cap out
// below the newest ones, which is what phpVersionsLocked records -- so a empirical job
// takes locked dependencies where that works and highest elsewhere, matching what
// the hermetic matrix already does for the same version. Deriving this from
// phpVersionsLocked means a regenerated lock file only has to be recorded there.
local empiricalDep(php) = if std.member(phpVersionsLocked, php) then 'locked' else 'highest';

// Documentation examples drive the same mutual-TLS path as the empirical tests, so running
// them on a single job is enough; pick the most widely deployed engine.
local empiricalDocsEngine = if std.member(sslEngines, 'openssl') then 'openssl' else sslEngines[0];

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
  name: 'wiremock/wiremock:3x@sha256:0d4ecb3e4dc8213fd7a4d37d6a78f6e6b553a6d2e15bd51b0999781282ac61b3',
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
    'just test-hermetic',
  ] + (if dep == 'locked' then ['just test-minimal-runtime'] else []),
  coverage: '/Lines:\\s+\\d+(?:\\.\\d+)?%/',
  artifacts: {
    reports: {
      junit: 'build/junit.xml',
      cobertura: 'build/coverage/cobertura.xml',
    },
  },
};

// No WireMock service and no `just wiremock-setup`: every test in this lane is
// expected to reach the real API, and `just test-empirical` fails if one does not.
local empiricalJob(combo) = phpJob(combo.php, combo.ssl, empiricalDep(combo.php), 'test') + envFile + {
  variables+: { TWINT_SDK_PHP_CURL_SSL_ENGINE: combo.ssl },
  script+: [
    'just test-empirical',
  ] + (if combo.ssl == empiricalDocsEngine then ['just run-docs-examples'] else []),
  // PAT is a shared external system; a transport hiccup should not fail the pipeline.
  retry: { max: 2, when: ['script_failure'] },
  artifacts: {
    when: 'always',
    // The response log is the only record of what the API actually returned; ext-soap
    // reduces every non-XML response to "looks like we got no XML document".
    paths: ['build/empirical-responses.log'],
    reports: {
      junit: 'build/junit.xml',
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

local empiricalJobs = {
  ['empirical-%s-%s-%s' % [combo.php, combo.ssl, empiricalDep(combo.php)]]: empiricalJob(combo)
  for combo in empiricalCombos
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

assert std.length(phpVersions) > 0 : 'resources-dev/php must define at least one PHP version';
assert std.set([combo.ssl for combo in empiricalCombos]) == sslEngines :
       'every SSL engine must appear in the empirical lane: it is the only lane that performs a TLS handshake';

{ stages: ['build', 'test', 'check', 'codegen', 'release'] }
+ containerJobs
+ testJobs
+ empiricalJobs
+ staticAnalysisJobs
+ codegenJobs
+ {
  'format-and-docs-check': formatAndDocsCheckJob,
  release: releaseJob,
}
