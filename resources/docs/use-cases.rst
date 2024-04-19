*********
Use cases
*********

General
============

Identifiers
-----------

The central identifier for orders with TWINT is the Order UUID TWINT generates when a starting a new order. This
identifiers should be stored in the merchant's system to be able to track the order status. The merchant must also pass
a merchant reference ID to the order to TWINT (alphanumeric string, maximum 50 characters).


Filed & unfiled merchant transaction reference
``````````````````````````````````````````````

To reduce the likelihood of passing the wrong identifier to the TWINT API, the SDK differentiates between "filed" and
"unfiled" merchant transaction reference. The filed reference is the one that was already passed to the TWINT system
and is stored in the TWINT system. The unfiled reference is the one that is stored in the merchant's system and is not
yet passed to the TWINT system.

So you start a new order with an unfiled reference and when the order is started you can call monitor only with a filed
reference.

Error handling
--------------

.. todo::
    Add error handling section

Implementing a regular/multi-step checkout
==========================================

Start order
-----------

To start a new order the ``startOrder`` method of the ``Twint\Sdk\Client`` class is called. The method returns an
``Twint\Sdk\Value\Order``` object that contains order ID, order status, pairing token and the QR code.

.. literalinclude:: _examples/regular-checkout.example.php
    :language: PHP
    :end-before: // Access order ID end

The order ID is the central identifier for the order and should be stored in the merchant's system to be able to track
the order status.

The pairing token is used to enable the customer to confirm the payment in the TWINT app.

.. literalinclude:: _examples/regular-checkout.example.php
    :language: PHP
    :start-after: // Access pairing token start
    :end-before: // Access pairing token end

The QR code is a visual representation of the pairing token that can be displayed to the customer.

.. literalinclude:: _examples/regular-checkout.example.php
    :language: PHP
    :start-after: // Access QR code start
    :end-before: // Access QR code end

.. warning::
    As of today, the only supported currency is Swiss Francs (CHF).

Monitor order
-------------

Once the order is started, the customer has to confirm the order. To find out if that confirmation has happened,
``monitorOrder`` of the ``Twint\Sdk\Client`` class should be called. The method returns an ``Twint\Sdk\Value\Order``
object that contains the updated order status.

.. literalinclude:: _examples/regular-checkout.example.php
    :language: PHP
    :start-after: // Monitor order start
    :end-before: // Monitor order end

Check if the order is pending:

.. literalinclude:: _examples/regular-checkout.example.php
    :language: PHP
    :start-after: // Check if order is pending start
    :end-before: // Check if order is pending end

And while the order is pending, call monitor again and again at a reasonable frequency until it is either successful
or has failed:

.. literalinclude:: _examples/regular-checkout.example.php
    :language: PHP
    :start-after: // Check if order status is conclusive start
    :end-before: // Check if order status is conclusive end

Cancel order
------------
Pending orders can be cancelled using the ``cancelOrder`` method of the ``Twint\Sdk\Client`` class. The method returns
an ``Twint\Sdk\Value\Order``` object that contains the updated order status.

.. literalinclude:: _examples/regular-checkout.example.php
    :language: PHP
    :start-after: // Cancel order start
    :end-before: // Cancel order end


Confirm order
-------------
If the order is successful, call the ``confirmOrder`` method of the ``Twint\Sdk\Client`` class to confirm the order.
After confirming an order the purchased goods, physical or digital, can be safely delivered to the customer. The amount
passed enables for partial confirmations but in 99% of the cases the amount will be the same as with ``startOrder``.

.. literalinclude:: _examples/regular-checkout.example.php
    :language: PHP
    :start-after: // Confirm order start
    :end-before: // Confirm order end

.. note::
    Once the order has been confirmed, it can only be refunded using ``reverseOrder`` and ``cancelOrder`` will no longer
    work.

Reverse order
-------------

To support refunds, the ``reverseOrder`` method of the ``Twint\Sdk\Client`` class can be called. For reversals, a new
merchant reference need to be passed as a reference for the specific reversal. As multiple partial reversals are
supported for a single order, the merchant reference for the reversal should be unique for each reversal.

In this example, the partial amount of 9.95 CHF will be refunded.

.. literalinclude:: _examples/regular-checkout.example.php
    :language: PHP
    :start-after: // Partial reversal order start
    :end-before: // Partial reversal order end

Let’s reverse the remaining amount of 90.00 CHF.

.. literalinclude:: _examples/regular-checkout.example.php
    :language: PHP
    :start-after: // Remaining reversal order start
    :end-before: // Remaining reversal order end

.. note::
    The reversal ID in this example is computed from the order ID and for each reversal the index is increased. The
    ecommerce platform at hand most likely offers a more sophisticated way to generate unique reversal IDs.

Handling end-user devices
=========================

Implementing checkout with TWINT requires implementing differentiated experiences dependent on the platform of the
user.

 * Desktop users scan the QR code on the screen with their TWINT mobile app
 * Android users are redirected to the installed TWINT app
 * iOS users are asked to select their TWINT app of choice and then redirected to the selected app

The capability interface ``Twint\Sdk\Capability\DeviceHandling`` should be used to handle devices.

Detecting the device
--------------------

The device can be detected using the ``detectDevice`` method of the ``Twint\Sdk\Client`` class. The method returns
a ``Twint\Sdk\Value\DetectedDevice`` object. ``isIos``, ``isAndroid`` to find out if the user agent is of the respective
platform. ``isMobile`` can be used to find out if the user agent is a mobile device (Android or iOS). ``isUnknown`` can
be used to find out if the user agent is unknown and for the unknown case, the desktop flow should be presented.

.. literalinclude:: _examples/device-detection.example.php
    :language: PHP

Get iOS app schemes
-------------------

To enable iOS users to select from the available TWINT apps, the app schemes of the available TWINT apps can be
retrieved using the ``getIosAppSchemes`` method of the ``Twint\Sdk\Client`` class. The method returns an array of
``Twint\Sdk\Value\IosAppScheme`` object.

.. literalinclude:: _examples/ios-app-schemes.example.php
    :language: PHP
