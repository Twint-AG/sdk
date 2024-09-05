<?php

namespace Acme;

use Twint\Sdk\Client;
use Twint\Sdk\Value\CustomerDataScopes;
use Twint\Sdk\Value\Money;
use Twint\Sdk\Value\ShippingMethod;
use Twint\Sdk\Value\ShippingMethodId;
use Twint\Sdk\Value\ShippingMethods;
use Twint\Sdk\Value\StoreUuid;
use Twint\Sdk\Value\UnfiledMerchantTransactionReference;

$client = new Client(
    $certificateContainer,
    StoreUuid::fromString($storeUuid),
    $version,
    $environment
);

$initialCheckIn = $client->requestFastCheckoutCheckIn(
    Money::CHF(9.95),
    new CustomerDataScopes(
        CustomerDataScopes::EMAIL,
        CustomerDataScopes::PHONE_NUMBER,
        CustomerDataScopes::SHIPPING_ADDRESS,
        CustomerDataScopes::DATE_OF_BIRTH
    ),
    new ShippingMethods(
        new ShippingMethod(
            new ShippingMethodId('regular-shipping-method-id'),
            'Regular Shipping',
            Money::CHF(5.00)
        ),
        new ShippingMethod(
            new ShippingMethodId('express-shipping-method-id'),
            'Express Shipping',
            Money::CHF(10.00)
        )
    )
);
// Request fast checkout check-in end

// Request fast checkout check-in minimal start
$initialCheckIn = $client->requestFastCheckoutCheckIn(
    Money::CHF(9.95),
    new CustomerDataScopes(
        CustomerDataScopes::EMAIL,
        CustomerDataScopes::SHIPPING_ADDRESS
    ),
    new ShippingMethods()
);
// Request fast checkout check-in minimal end

// Monitor fast checkout check-in start
$checkIn = $client->monitorFastCheckoutCheckIn(
    $initialCheckIn->pairingUuid()
);

if ($checkIn->isPaired()) {
    // Continue with fast checkout
}
// Monitor fast checkout check-in end


// Access customer data start
if ($checkIn->isPaired()) {
    if ($checkIn->hasCustomerData()) {
        $customerData = $checkIn->customerData();
        $shippingAddress = $customerData->shippingAddress();
        $email = $customerData->email();
        $phoneNumber = $customerData->phoneNumber();
        $dateOfBirth = $customerData->dateOfBirth();
    }
}
// Access customer data end


// Access shipping method start
if ($checkIn->isPaired()) {
    if ($checkIn->hasShippingMethodId()) {
        $shippingMethodId = $checkIn->shippingMethodId();
    }
}
// Access shipping method end

// Start fast checkout order start
if ($checkIn->isPaired()) {
    $order = $client->startFastCheckoutOrder(
        $initialCheckIn->pairingUuid(),
        new UnfiledMerchantTransactionReference($orderReference),
        Money::CHF(14.95)
    );
}
// Start fast checkout order end

// Cancel fast checkout check-in start
$client->cancelFastCheckoutCheckIn(
    $initialCheckIn->pairingUuid()
);
// Cancel fast checkout check-in end
