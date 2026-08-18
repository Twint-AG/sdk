# TWINT SDK

PHP SDK for TWINT.

## Development

### Setup
 * Run `just dev` to start the development environment based on `docker compose` and enter a shell
 * Copy `.env.dist` to `.env` and configure your values
 * Run `just install` to install composer dependencies

### Tests
Tests are split into two lanes. The **hermetic** lane runs against WireMock or against
nothing at all, and CI runs it on the full PHP/SSL matrix. The **empirical** lane holds the
tests that talk to the real TWINT API, marked `#[Group('empirical')]`, and CI runs one job
per SSL engine.

 * Run `just test` for both lanes, including the tests that hit the real TWINT API
   * Run `just wiremock-setup` once, if you want to set up the local WireMock mappings
 * Run `just test-hermetic` for the hermetic lane alone, the way CI runs it
 * Run `just test-empirical` for the tests that hit the real TWINT API alone
 * Run `just test-unit` to run unit tests only
 * Run `just test-integration` to run integration tests only

Reaching the real TWINT API is opt-in: unless `TWINT_SDK_TESTS_EMPIRICAL` is set, any
request not aimed at WireMock fails. So a plain `vendor/bin/phpunit` cannot touch the real
API, and `just test-hermetic` needs no flag at all. If a new test does reach it, either stub
the SOAP operation with `enableWireMockForSoapMethod()` or mark the test
`#[Group('empirical')]` and run it with `just test-empirical`.

Whenever the real API is permitted, every response is written to
`build/empirical-responses.log` as one JSON object per line, because ext-soap reduces any
non-XML response to `looks like we got no XML document` and hides the status code and body
that explain it. The CI empirical jobs upload it as an artifact, so a failure can be read
back with e.g.

```console
$ jq -r 'select(.status != 200) | .body' build/empirical-responses.log
```

Set `TWINT_SDK_TESTS_EMPIRICAL_LOG` to a path to write it from any other recipe.

### All checks
* Run `just check` to run all checks (tests, static analysis, linting, codegen). This should be done before pushing
  changes.
* Run `just static-analysis` to run PHPStan
* Run `just format` to apply auto-formatting

### Documentation
* Run `just dev-docs` to enter shell
* Run `just docs` to generate documentation

### Code generation
Place new WSDL and XSD files in `resources/wsdl` directory and run `just codegen` to update the generated code.

### Release
Run `just tag <version>`, e.g. `just tag 1.0.0`, to create a new release tag. This will also push the tag to
the remote repository and trigger synchronization with GitHub/Packagist.

### Multi-version PHP development
The default PHP version for development is 8.1 but the SDK also supports 8.2, 8.3, 8.4, and 8.5. To switch the PHP version,
edit `TWINT_SDK_PHP_VERSION` in the `.env` file and run `just restart` to boot the development environment with the
selected PHP version.

The SSL engine can be changed via `TWINT_SDK_PHP_CURL_SSL_ENGINE` in `.env` (options: `openssl`, `nss`, `nss-nobignum`,
`gnutls`). The pinned base image for each combination is in `resources-dev/php/` and managed by Renovate.
