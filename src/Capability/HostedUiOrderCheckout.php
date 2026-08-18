<?php

declare(strict_types=1);

namespace Twint\Sdk\Capability;

use Twint\Sdk\Value\Money;
use Twint\Sdk\Value\NumericPairingToken;
use Twint\Sdk\Value\Order;
use Twint\Sdk\Value\PairingStatus;
use Twint\Sdk\Value\PaymentUrl;
use Twint\Sdk\Value\UnfiledMerchantTransactionReference;

interface HostedUiOrderCheckout extends OrderAdministration
{
    /**
     * @return Order<PairingStatus::*, NumericPairingToken, null, PaymentUrl>
     */
    public function startHostedOrder(
        UnfiledMerchantTransactionReference $orderReference,
        Money $requestedAmount
    ): Order;
}
