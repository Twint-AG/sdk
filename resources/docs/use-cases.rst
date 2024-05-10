.. include:: symbols.rst

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

To start a new order the |method-client-start-order| method of the |class-client| class is called. The method returns an
|class-value-order| object that contains order ID, order status, pairing token and the QR code.

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

Once the order is started, the customer has to confirm or cancel the order. To find
out if the user interaction has concluded yet or any other order status changes, |method-client-monitor-order| of the
|class-client| class should be called. The method returns an |class-value-order| object that contains the updated
statuses.

.. literalinclude:: _examples/regular-checkout.example.php
    :language: PHP
    :start-after: // Monitor order start
    :end-before: // Monitor order end

Check if the order requires user interaction (either the user has to confirm or cancel the order):

.. literalinclude:: _examples/regular-checkout.example.php
    :language: PHP
    :start-after: // Check if order is waiting for user interaction start
    :end-before: // Check if order is waiting for user interaction end

Confirm order
-------------
The SDK will always start orders that are implicitly confirmed, meaning: as soon as the user confirms the order, the
amount will be charged. Still in rare cases, e.g. when the initial order has been started with requiring explicit
merchant confirmation, it might be necessary to manually confirm the order.

To check if an order needs confirmation, call |method-value-order-is-confirmation-pending| on the |class-value-order|
object before calling the |method-client-confirm-order| method of the |class-client| object.

.. literalinclude:: _examples/regular-checkout.example.php
    :language: PHP
    :start-after: // Check if order needs merchant confirmation start
    :end-before: // Check if order needs merchant confirmation end

.. note::
    Once the order has been confirmed, be it implicitly or explicitly, it can only be refunded using
    |fq-method-client-reverse-order| and |method-client-cancel-order| will no longer work.


Concluding the order
--------------------

Once the order is confirmed, be it implicitly or explicitly, the order is concluded and the amount is charged. The
order status will be updated to |const-value-order-status-success|.

.. literalinclude:: _examples/regular-checkout.example.php
    :language: PHP
    :start-after: // Conclude order start
    :end-before: // Conclude order end

Cancel order
------------
Pending orders can be cancelled using the |method-client-cancel-order| method of the |class-client| class. The method
returns an |class-value-order| object that contains the updated order status.

.. literalinclude:: _examples/regular-checkout.example.php
    :language: PHP
    :start-after: // Cancel order start
    :end-before: // Cancel order end

Reverse order
-------------

To support refunds, the |method-client-reverse-order| method of the |class-client| class can be called. For reversals,
a new merchant reference need to be passed as a reference for the specific reversal. As multiple partial reversals are
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

The capability interface |interface-capability-device-handling| should be used to handle devices.

Detecting the device
--------------------

The device can be detected using the |method-client-detect-device| method of the |class-client| class. The method
returns a |class-value-detected-device| object. Use |method-value-detected-device-is-ios| and
|method-value-detected-device-is-android| to find out if the user agent is of the respective
platform. |method-value-detected-device-is-mobile| can be used to find out if the user agent is a mobile device
(Android or iOS). |method-value-detected-device-is-unknown| can be used to find out if the user agent is unknown and
for the unknown case, the desktop flow should be presented.

.. literalinclude:: _examples/device-detection.example.php
    :language: PHP

Get iOS app schemes
-------------------

To enable iOS users to select from the available TWINT apps, the app schemes of the available TWINT apps can be
retrieved using the |method-client-get-ios-app-schemes| method of the |class-client| class. The method returns an array
of |class-value-ios-app-scheme| object.

.. literalinclude:: _examples/ios-app-schemes.example.php
    :language: PHP
