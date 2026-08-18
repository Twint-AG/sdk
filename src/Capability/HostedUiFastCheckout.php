<?php

declare(strict_types=1);

namespace Twint\Sdk\Capability;

use Twint\Sdk\Value\CustomerDataScopes;
use Twint\Sdk\Value\InteractiveFastCheckoutCheckIn;
use Twint\Sdk\Value\Money;
use Twint\Sdk\Value\Order;
use Twint\Sdk\Value\PairingStatus;
use Twint\Sdk\Value\PairingUuid;
use Twint\Sdk\Value\PaymentUrl;
use Twint\Sdk\Value\ShippingMethods;
use Twint\Sdk\Value\UnfiledMerchantTransactionReference;

interface HostedUiFastCheckout extends FastCheckoutAdministration
{
    /**
     * @return InteractiveFastCheckoutCheckIn<null, PaymentUrl>
     */
    public function requestHostedFastCheckoutCheckIn(
        Money $amountWithoutShipping,
        CustomerDataScopes $scopes,
        ShippingMethods $shippingMethods,
    ): InteractiveFastCheckoutCheckIn;

    /**
     * @return Order<PairingStatus::*, null, null, null>
     */
    public function startHostedFastCheckoutOrder(
        PairingUuid $pairingUuid,
        UnfiledMerchantTransactionReference $orderReference,
        Money $requestedAmount
    ): Order;
}
