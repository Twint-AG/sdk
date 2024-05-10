.. include:: symbols.rst
.. _authentication:

******************
TLS authentication
******************

TWINT uses a TLS client certificate to authenticate API requests. When a new certificate is provided, it is important to
ensure that the certificate is valid and that the certificate can be used to connect to the TWINT API.


Establishing trust
==================

When a new PKCS #12 file is provided in a merchant system it needs to be checked if it is formally valid and therefore
trustworthy enough to present the certificate to the TWINT API.

.. literalinclude:: _examples/certificate-trust-connectivity.example.php
    :language: PHP
    :end-before: // Handle errors

|method-certificate-pkcs12-certificate-establish-trust| will throw an exception of type
|class-exception-invalid-certificate|. This exception provides a |method-exception-invalid-certificate-get-errors|
method that returns a list of errors that were encountered during the validation process. Check the constants in
|class-exception-invalid-certificate| for a list of possible errors.

.. literalinclude:: _examples/certificate-trust-connectivity.example.php
    :language: PHP
    :start-at: // Establish trust
    :end-before: // Check API connectivity

Ensuring connectivity
=====================

Now that the certificate is trustworthy enough to use it with the TWINT API, use the |method-client-check-system-status|
method provided by the SDK to ensure that the certificate is correctly configured and that the TWINT API is reachable.

.. literalinclude:: _examples/certificate-trust-connectivity.example.php
    :language: PHP
    :start-at: // Check API connectivity

Handling certificate formats
============================

TWINT provides the API certificate as a PKCS #12 file.  PHP on the other hand, specifically ext/soap, uses PEM files.
The SDK provides the ability to convert between these formats.

.. literalinclude:: _examples/certificate-conversion.example.php
    :language: PHP
    :end-before: // Write to temporary file

Performance considerations
--------------------------

Converting from PKCS #12 to PEM is not free and so it makes the most sense to convert from PKCS #12 to PEM once and
then store the PEM file for future use.

The certificate can be written to a static file:

.. literalinclude:: _examples/certificate-conversion.example.php
    :language: PHP
    :start-at: // Write to static file
    :end-before: // Write to temporary file

Or to a temporary file:

.. literalinclude:: _examples/certificate-conversion.example.php
    :language: PHP
    :start-at: // Write to temporary file
    :end-before: // Write to a static file with the certificate fingerprint

Last but not least, a certificate can be written to a file with the certificate fingerprint as the filename using the
|class-io-content-sensitive-file-writer|:

.. literalinclude:: _examples/certificate-conversion.example.php
    :language: PHP
    :start-at: // Write to a static file with the certificate fingerprint
