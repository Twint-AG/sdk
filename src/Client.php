<?php

declare(strict_types=1);

namespace Twint\Sdk;

use Twint\Sdk\Value\DetectedDevice;
use Twint\Sdk\Value\FiledMerchantTransactionReference;
use Twint\Sdk\Value\IosAppScheme;
use Twint\Sdk\Value\Money;
use Twint\Sdk\Value\Order;
use Twint\Sdk\Value\OrderId;
use Twint\Sdk\Value\PairingStatus;
use Twint\Sdk\Value\PairingToken;
use Twint\Sdk\Value\UnfiledMerchantTransactionReference;

interface Client
{
    /**
     * @return Order<PairingStatus, PairingToken>
     */
    public function startOrder(UnfiledMerchantTransactionReference $orderReference, Money $requestedAmount): Order;

    /**
     * @return Order<PairingStatus, null>
     */
    public function monitorOrder(OrderId|FiledMerchantTransactionReference $orderIdOrRef): Order;

    /**
     * @return Order<null, null>
     */
    public function confirmOrder(
        OrderId|FiledMerchantTransactionReference $orderIdOrRef,
        Money $requestedAmount
    ): Order;

    /**
     * @return Order<null, null>
     */
    public function reverseOrder(
        UnfiledMerchantTransactionReference $reversalReference,
        OrderId|FiledMerchantTransactionReference $orderIdOrRef,
        Money $reversalAmount,
    ): Order;

    public function detectDevice(string $userAgent): DetectedDevice;

    /**
     * @return list<IosAppScheme>
     */
    public function getIosAppSchemes(): array;
}
