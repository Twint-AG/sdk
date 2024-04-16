<?php

declare(strict_types=1);

namespace Twint\Sdk\Capability;

use Twint\Sdk\Value\FiledMerchantTransactionReference;
use Twint\Sdk\Value\Order;
use Twint\Sdk\Value\OrderId;
use Twint\Sdk\Value\PairingStatus;

interface OrderMonitoring extends Capability
{
    /**
     * @return Order<PairingStatus, null, null>
     */
    public function monitorOrder(OrderId|FiledMerchantTransactionReference $orderIdOrRef): Order;
}
