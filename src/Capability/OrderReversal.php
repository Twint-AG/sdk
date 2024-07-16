<?php

declare(strict_types=1);

namespace Twint\Sdk\Capability;

use Twint\Sdk\Value\Money;
use Twint\Sdk\Value\Order;
use Twint\Sdk\Value\OrderReference;
use Twint\Sdk\Value\UnfiledMerchantTransactionReference;

interface OrderReversal extends OrderMonitoring
{
    /**
     * @return Order<null, null, null>
     */
    public function reverseOrder(
        UnfiledMerchantTransactionReference $reversalReference,
        OrderReference $orderReference,
        Money $reversalAmount,
    ): Order;
}
