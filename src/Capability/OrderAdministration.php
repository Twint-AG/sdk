<?php

declare(strict_types=1);

namespace Twint\Sdk\Capability;

use Twint\Sdk\Value\Money;
use Twint\Sdk\Value\Order;
use Twint\Sdk\Value\OrderReference;

interface OrderAdministration extends OrderMonitoring, OrderReversal
{
    /**
     * @return Order<null, null, null>
     */
    public function cancelOrder(OrderReference $orderReference): Order;

    /**
     * @return Order<null, null, null>
     */
    public function confirmOrder(OrderReference $orderReference, Money $requestedAmount): Order;
}
