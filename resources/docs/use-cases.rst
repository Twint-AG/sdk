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
The SDK creates orders that require explicit confirmation from the merchant: it’s not enough that the customer has
confirmed the order in the app, the merchant also needs to explicitly confirm for the amount to be transferred.

To check if an order needs confirmation, call |method-value-order-is-confirmation-pending| on the |class-value-order|
object before calling the |method-client-confirm-order| method of the |class-client| object.

.. literalinclude:: _examples/regular-checkout.example.php
    :language: PHP
    :start-after: // Check if order needs merchant confirmation start
    :end-before: // Check if order needs merchant confirmation end

.. note::
    Once the order has been confirmed it can only be refunded using
    |fq-method-client-reverse-order| and |method-client-cancel-order| will no longer work.


Concluding the order
--------------------

Once the order is confirmed, the order is concluded and the amount is transferred. The order status will be updated
to |const-value-order-status-success|.

.. literalinclude:: _examples/regular-checkout.example.php
    :language: PHP
    :start-after: // Conclude order start
    :end-before: // Conclude order end

Cancel order
------------
Pending orders can be canceled using the |method-client-cancel-order| method of the |class-client| class. The method
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
    e-commerce platform at hand most likely offers a more sophisticated way to generate unique reversal IDs.

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

Implementing TWINT express checkout
===================================

TWINT offers the possibility to implement an express checkout (internally called "fast checkout"). The express
checkout is a simplified checkout process where the customer is redirected to the TWINT app to confirm the payment
and the customer data is provided by TWINT to the merchant.

The necessary capabilities are provided by the |interface-capability-fast-checkout| interface.

Starting an express checkout check-in
-------------------------------------

When starting an express checkout, the amount (excluding shipping costs) is passed to the
|method-client-request-fast-checkout-check-in| method of the |class-client| class. Additionally a list of required
customer data scopes (|class-value-customer-data-scopes|) should be passed. For physical products that require shipping,
the list of available shipping methods must be passed as well. The customer will select their shipping method and the
amount will be charged according to the selected shipping method.

.. literalinclude:: _examples/express-checkout.example.php
    :language: PHP
    :end-before: Request fast checkout check-in end

A merchant can also request a more minimal set of data, e.g. for digital products.

.. literalinclude:: _examples/express-checkout.example.php
    :language: PHP
    :start-after: Request fast checkout check-in minimal start
    :end-before: Request fast checkout check-in minimal end

.. note::
    TWINT does not offer a separate billing address so the billing address is always the same as the shipping address.

Monitoring the express checkout check-in
----------------------------------------

To find out if the customer has approved the express checkout check-in yet, the method
|method-client-monitor-fast-checkout-check-in| is called and the |class-value-pairing-uuid| object
returned by from |fq-method-value-interactive-fast-checkout-check-in-pairing-token| is used to identity the check-in
going forward.
|method-client-monitor-fast-checkout-check-in| returns an |class-value-fast-checkout-check-in| object that offers the
method |method-value-fast-checkout-check-in-is-paired| to check if the check-in is paired.

.. literalinclude:: _examples/express-checkout.example.php
    :language: PHP
    :start-after: Monitor fast checkout check-in start
    :end-before: Monitor fast checkout check-in end

Once the pairing is successful, the requested customer data should be available. The customer data can be
be null if the customer has not set up their TWINT ID.

.. literalinclude:: _examples/express-checkout.example.php
    :language: PHP
    :start-after: Access customer data start
    :end-before: Access customer data end

.. warning::
    If the customer has not configured their TWINT ID in the TWINT app, the customer data will be null.

If shipping methods have been provided when requesting the fast checkout check-in, the selected shipping method can be
accessed and matched to the merchant's shipping methods.

.. literalinclude:: _examples/express-checkout.example.php
    :language: PHP
    :start-after: Access shipping method start
    :end-before: Access shipping method end

Cancelling the express checkout check-in
----------------------------------------

To abort the express checkout check-in, the |method-client-cancel-fast-checkout-check-in| method of the |class-client|
class can be called. This cancels the check-in and an order can no longer be created with the check-in.

.. literalinclude:: _examples/express-checkout.example.php
    :language: PHP
    :start-after: Cancel fast checkout check-in start
    :end-before: Cancel fast checkout check-in end

Creating the actual order
-------------------------

Once the check-in is paired, the order can be created using the |method-client-start-fast-checkout-order| method. The
method returns an |class-value-order| object that contains the order ID.
Similar to |method-client-start-order|, a merchant reference ID is passed to identify the order in the merchant's
system.
The amount passed to the |method-client-start-fast-checkout-order| method should be the total amount including shipping
costs as selected by the user.

.. literalinclude:: _examples/express-checkout.example.php
    :language: PHP
    :start-after: Start fast checkout order start
    :end-before: Start fast checkout order end

Now continue with the regular checkout flow, starting at `Monitor order`_. The major difference being, that the order is
already confirmed.

Introspecting API interactions
==============================

The SDK provides a way to introspect the API interactions. This can be helpful to implement transactions logs to
provide traceability. The |interface-invocation-recorder-capability-invocation-recorder| interface offers method
|method-invocation-recorder-capability-invocation-recorder-flush-invocations| to retrieve a list of
|class-invocation-recorder-value-invocation| objects. Each invocation object contains a list of related SOAP messages, available
through |fq-method-invocation-recorder-value-invocation-messages|.

.. note::
    Calling |method-invocation-recorder-capability-invocation-recorder-flush-invocations| will clear the invocations.

To enable the recording capability, the |class-client| object should be decorated with the
|class-invocation-recorder-invocation-recording-client| and the SOAP transport must be wrapped with the
|class-invocation-recorder-soap-recording-transport|.

.. literalinclude:: _examples/invocation-recorder.example.php
    :language: PHP

.. note::
    Calling |class-invocation-recorder-invocation-recording-client| implements the capability interface
    |interface-invocation-recorder-capability-invocation-recorder|.
