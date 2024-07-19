# TWINT SDK

PHP SDK for TWINT.

## Development

### Setup
 * Run `make dev` to start the development environment based on `docker compose` and enter a shell
 * Copy `.env.example` to `.env` and configure your values
 * Run `make install` to install composer dependencies

### Tests
 * Run `make test`
   * Run `make wiremock-setup` once, if you want to set up the local WireMock mappings
 * Run `make test-unit` to run unit tests only
 * Run `make test-integration` to run integration tests only

### All checks
* Run `make check` to run all checks (tests, static analysis, linting, codegen). This should be done before pushing
  changes.
* Run `make static-analysis` to run PHPStan
* Run `make format` to apply auto-formatting

### Documentation
* Run `make dev-docs` to enter shell
* Run `make docs` to generate documentation

### Code generation
Place new WSDL and XSD files in `resources/wsdl` directory and run `make codegen` to update the generated code.

### Release
Run `VERSION=… make tag`, e.g. `VERSION=1.0.0 make tag`, to create a new release tag. This will also push the tag to
the remote repository and trigger synchronization with GitHub/Packagist.

### Multi-version PHP development
The default PHP version for development is 8.1 but the SDK also supports 8.2. and 8.3. To switch the PHP version,
edit `TWINT_SDK_PHP_VERSION` in the `.env` file and run `make restart` to boot the development environment with the
selected PHP version.
