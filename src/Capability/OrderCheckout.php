<?php

declare(strict_types=1);

namespace Twint\Sdk\Capability;

use Twint\Sdk\Value\Money;
use Twint\Sdk\Value\Order;
use Twint\Sdk\Value\PairingStatus;
use Twint\Sdk\Value\PairingToken;
use Twint\Sdk\Value\QrCode;
use Twint\Sdk\Value\UnfiledMerchantTransactionReference;

interface OrderCheckout extends OrderAdministration
{
    /**
     * @return Order<PairingStatus, PairingToken, QrCode>
     */
    public function startOrder(UnfiledMerchantTransactionReference $orderReference, Money $requestedAmount): Order;
}
