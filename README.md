# TWINT SDK

PHP SDK for TWINT to enable e-commerce use cases.

## Development

### Setup
 * Run `make dev` to start the development environment based on `docker compose` and enter a shell
 * Copy `.env.example` to `.env` and configure your values

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

### Code generation
Place new WSDL and XSD files in `resources/wsdl` directory and run `make codegen` to update the generated code.

### Multi-version PHP development
The default PHP version for development is 8.1 but the SDK also supports 8.2. and 8.3. To switch the PHP version,
edit `TWINT_SDK_PHP_VERSION` in the `.env` file and run `make restart` to boot the development environment with the
selected PHP version.