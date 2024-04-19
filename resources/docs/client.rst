**********
API client
**********

The TWINT SDK provides ``Twint\Sdk\Client`` as the central way to interact with the TWINT API. It provides a drastically
simplified API with a focus on ecommerce use cases. That means: if it’s not relevant for an ecommerce use case, it's not
exposed in the SDK.

Instantiating the client
========================

To instantiate a client, a certificate container and the merchant ID are required. Additionally, an API version and the
environment to work with must be selected.

Check out :ref:`authentication` to understand how to obtain the certificate container. The merchant ID is a UUID
provided by TWINT.

.. literalinclude:: _examples/client-instantiation.example.php
    :language: PHP
    :end-before: // Production start

To select the production environment, use the ``Twint\Sdk\Value\Environment::PRODUCTION``. For the testing environment,
use the ``Twint\Sdk\Value\Environment::TESTING``.

.. literalinclude:: _examples/client-instantiation.example.php
    :language: PHP
    :start-after: // Production start
    :end-before: // Production end
    :emphasize-lines: 5

In 99% of the cases using the latest version of the API is correct. Only in rare cases, e.g. to test upcoming features,
it might be necessary to use a different version.

.. note::
    The creation of the client is best managed in some kind of service container or factory. This is to avoid creating
    the client multiple times and to ensure that the client is created with the correct configuration.

Passing custom factories
------------------------

The client is built with a set of factories that create the necessary objects. In some cases, it might be necessary to
replace these factories with custom implementations. This can be done by passing the factories to the client.

Let’s assume that the certificate has been converted from PKCS #12 to PEM already and the goal is to avoid unnecessary
file writes as much as possible. Pass a content sensitive file writer to the client that will store the certificate
locally based on the fingerprint of the certificate. It will avoid recreating the local file if the certificate file
with the given fingerprint already exists.

.. literalinclude:: _examples/client-instantiation.example.php
    :language: PHP
    :start-after: // Custom file writer start
    :end-before: // Custom file writer end
    :emphasize-lines: 6-10

Capability interfaces
=====================

To provide minimal interfaces for each use-case that are easy to mock and test, the SDK uses capability interfaces.
These interfaces provide a discrete set of methods that are required to fulfill a specific task.

It is recommended to use these interfaces in the application code to make the code more testable and to avoid tight
coupling to the SDK client.

So instead of depending on the client, depend on the capability interfaces. As the SDK client implements the capability
interfaces, the client can be passed to the application code. In turn, the application code will only depend on the
smaller capability interfaces.


.. literalinclude:: _examples/capability-interface.example.php
    :language: PHP
    :emphasize-lines: 13
