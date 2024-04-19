<?php

namespace Acme;

use Twint\Sdk\Capability\OrderReversal;
use Twint\Sdk\Value\Money;
use Twint\Sdk\Value\OrderId;
use Twint\Sdk\Value\UnfiledMerchantTransactionReference;

final class ReverseOrders
{
    public function __construct(
        private readonly OrderReversal $orderReversal
    ) {
    }

    public function reverse(
        OrderId $orderIdToReverse,
        Money $reversalAmount
    ): void {
        $reversal = $this->orderReversal->reverseOrder(
            self::createReversalId($orderIdToReverse),
            $orderIdToReverse,
            $reversalAmount
        );

        $reversalId = $reversal->id();

        while (!$reversal->isPending()) {
            $reversal = $this->orderReversal
                ->monitorOrder($reversalId);
        }

        if ($reversal->isFailure()) {
            // Handle failure
        }

        if ($reversal->isSuccessful()) {
            // Handle success
        }
    }

    private static function createReversalId(
        OrderId $orderIdToReverse
    ): UnfiledMerchantTransactionReference {
        // This is a terrible implementation of a reversal
        // reference. It would prevent multiple reversals
        // for the same order
        return new UnfiledMerchantTransactionReference(
            'R-' . $orderIdToReverse
        );
    }
}
