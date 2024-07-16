<?php

declare(strict_types=1);

namespace Twint\Sdk\Capability;

use Twint\Sdk\Value\Order;
use Twint\Sdk\Value\OrderReference;
use Twint\Sdk\Value\PairingStatus;

interface OrderMonitoring extends Capability
{
    /**
     * @return Order<PairingStatus, null, null>
     */
    public function monitorOrder(OrderReference $orderReference): Order;
}
