<?php

namespace Acme;

use Twint\Sdk\Client;
use Twint\Sdk\Exception\ApiFailure;
use Twint\Sdk\Value\Money;
use Twint\Sdk\Value\StoreUuid;
use Twint\Sdk\Value\UnfiledMerchantTransactionReference;

$client = new Client(
    $certificateContainer,
    StoreUuid::fromString($storeUuid),
    $version,
    $environment
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


// Check if order is waiting for user interaction start
if ($monitoredOrder->userInteractionRequired()) {
    $monitoredOrder = $client->monitorOrder($orderId);
    // Check again and again until user interaction
    // is no longer required
}
// Check if order is waiting for user interaction end


// Check if order needs merchant confirmation start
if ($monitoredOrder->isConfirmationPending()) {
    $confirmedOrder = $client->confirmOrder(
        $orderId,
        $monitoredOrder->amount()
    );
}
// Check if order needs merchant confirmation end

// Cancel order start
try {
    $canceledOrder = $client->cancelOrder($orderId);
} catch (ApiFailure $failure) {
    // Handle failure
}
// Cancel order end

$confirmedOrder = $monitoredOrder;
// Conclude order start
if ($confirmedOrder->isSuccessful()) {
    // Record success
}
// Conclude order end

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
    if (!$firstReversal->isSuccessful()) {
        // Handle failure
    }

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
    if (!$secondReversal->isSuccessful()) {
        // Handle failure
    }
} catch (ApiFailure $failure) {
    // Handle failure
}
++$reversalIndex;
// Remaining reversal order end
