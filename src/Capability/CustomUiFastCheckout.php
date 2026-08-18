<?php

declare(strict_types=1);

namespace Twint\Sdk\Capability;

use Twint\Sdk\Value\CustomerDataScopes;
use Twint\Sdk\Value\InteractiveFastCheckoutCheckIn;
use Twint\Sdk\Value\Money;
use Twint\Sdk\Value\Order;
use Twint\Sdk\Value\PairingStatus;
use Twint\Sdk\Value\PairingUuid;
use Twint\Sdk\Value\QrCode;
use Twint\Sdk\Value\ShippingMethods;
use Twint\Sdk\Value\UnfiledMerchantTransactionReference;

interface CustomUiFastCheckout extends FastCheckoutAdministration
{
    /**
     * @return InteractiveFastCheckoutCheckIn<QrCode, null>
     */
    public function requestFastCheckoutCheckIn(
        Money $amountWithoutShipping,
        CustomerDataScopes $scopes,
        ShippingMethods $shippingMethods,
    ): InteractiveFastCheckoutCheckIn;

    /**
     * @return Order<PairingStatus::*, null, null, null>
     */
    public function startFastCheckoutOrder(
        PairingUuid $pairingUuid,
        UnfiledMerchantTransactionReference $orderReference,
        Money $requestedAmount
    ): Order;
}
