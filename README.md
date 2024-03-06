# README
TBD

### Code generation
Run `make codegen` to regenerate the code from the WSDL specification.

### Update WSDL
Place new WSDL and XSD files in `wsdl` directory, change `WSDL_VERSION` constant in `resources/config/soap.php` and run
`make codegen` to update the generated code.

### Check
Run `make check` to check for errors