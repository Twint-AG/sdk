<?php

namespace Acme;

use Twint\Sdk\Client;
use Twint\Sdk\Exception\ApiFailure;
use Twint\Sdk\Value\Environment;
use Twint\Sdk\Value\MerchantId;
use Twint\Sdk\Value\Money;
use Twint\Sdk\Value\UnfiledMerchantTransactionReference;
use Twint\Sdk\Value\Version;

$client = new Client(
    $certificateContainer,
    MerchantId::fromString($merchantId),
    Version::latest(),
    Environment::TESTING()
);

$startedOrder = $client->startOrder(
    new UnfiledMerchantTransactionReference($orderReference),
    Money::CHF(99.95)
);

// Access order ID
$orderId = $startedOrder->id();
// Access order ID end

// Access pairing token start
$pairingToken = $startedOrder->pairingToken();
// Access pairing token end

// Access QR code start
$qrCode = $startedOrder->qrCode();
// Access QR code end


// Monitor order start
$monitoredOrder = $client->monitorOrder($orderId);
// Monitor order end

// Check if order is pending start
if ($monitoredOrder->isPending()) {
    // Order is pending
}
// Check if order is pending end

// Check if order status is conclusive start
if ($monitoredOrder->isSuccessful()) {
    // Order is successful
}

if ($monitoredOrder->isFailure()) {
    // Order has failed
}
// // Check if order status is conclusive end

// Cancel order start
try {
    $canceledOrder = $client->cancelOrder($orderId);
} catch (ApiFailure $failure) {
    // Handle failure
}
// Cancel order end

// Confirm order start
try {
    $confirmedOrder = $client->confirmOrder(
        $orderId,
        Money::CHF(99.95)
    );
} catch (ApiFailure $failure) {
    // Handle failure
}
// Confirm order end

// Partial reversal order start
$reversalIndex = 1;
$firstReversalReference = 'R-' . $orderId . '-' . $reversalIndex;
try {
    $firstReversal = $client->reverseOrder(
        new UnfiledMerchantTransactionReference(
            $firstReversalReference
        ),
        $orderId,
        Money::CHF(9.95)
    );
    ++$reversalIndex;
} catch (ApiFailure $failure) {
    // Handle failure
}
// Partial reversal order end

// Remaining reversal order start
$reversalReference = 'R-' . $orderId . '-' . $reversalIndex;
try {
    $secondReversal = $client->reverseOrder(
        new UnfiledMerchantTransactionReference($reversalReference),
        $orderId,
        Money::CHF(90.00)
    );
} catch (ApiFailure $failure) {
    // Handle failure
}
++$reversalIndex;
// Remaining reversal order end
