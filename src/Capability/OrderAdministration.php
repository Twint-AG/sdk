<?php

declare(strict_types=1);

namespace Twint\Sdk\Capability;

use Twint\Sdk\Value\FiledMerchantTransactionReference;
use Twint\Sdk\Value\Money;
use Twint\Sdk\Value\Order;
use Twint\Sdk\Value\OrderId;

interface OrderAdministration extends OrderMonitoring, OrderReversal
{
    /**
     * @return Order<null, null, null>
     */
    public function cancelOrder(OrderId|FiledMerchantTransactionReference $orderIdOrRef): Order;

    /**
     * @return Order<null, null, null>
     */
    public function confirmOrder(
        OrderId|FiledMerchantTransactionReference $orderIdOrRef,
        Money $requestedAmount
    ): Order;
}
