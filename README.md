# TWINT SDK

PHP SDK for TWINT.

## Development

### Setup
 * Run `just dev` to start the development environment based on `docker compose` and enter a shell
 * Copy `.env.dist` to `.env` and configure your values
 * Run `just install` to install composer dependencies

### Tests
 * Run `just test`
   * Run `just wiremock-setup` once, if you want to set up the local WireMock mappings
 * Run `just test-unit` to run unit tests only
 * Run `just test-integration` to run integration tests only

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
The default PHP version for development is 8.1 but the SDK also supports 8.2, 8.3, and 8.4. To switch the PHP version,
edit `TWINT_SDK_PHP_VERSION` in the `.env` file and run `just restart` to boot the development environment with the
selected PHP version.

The SSL engine can be changed via `TWINT_SDK_PHP_CURL_SSL_ENGINE` in `.env` (options: `openssl`, `nss`, `nss-nobignum`,
`gnutls`). The pinned base image for each combination is in `resources-dev/php/` and managed by Renovate.
