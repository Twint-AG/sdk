<?php

declare(strict_types=1);

namespace Twint\Sdk;

use Twint\Sdk\Value\CertificateRenewal;
use Twint\Sdk\Value\CertificateValidity;
use Twint\Sdk\Value\DetectedDevice;
use Twint\Sdk\Value\IosAppScheme;
use Twint\Sdk\Value\MerchantId;
use Twint\Sdk\Value\MerchantTransactionReference;
use Twint\Sdk\Value\Money;
use Twint\Sdk\Value\Order;
use Twint\Sdk\Value\OrderId;
use Twint\Sdk\Value\OrderKind;

interface Client
{
    public function getCertificateValidity(MerchantId $merchantId): CertificateValidity;

    public function renewCertificate(MerchantId $merchantId): CertificateRenewal;

    public function startOrder(
        MerchantId $merchantId,
        Money $requestedAmount,
        OrderKind $orderKind,
        MerchantTransactionReference $transactionReference,
    ): Order;

    public function monitorOrder(MerchantId $merchantId, OrderId|MerchantTransactionReference $id): Order;

    public function confirmOrder(
        MerchantId $merchantId,
        OrderId|MerchantTransactionReference $id,
        Money $requestedAmount
    ): Order;

    public function detectDevice(string $userAgent): DetectedDevice;

    /**
     * @return list<IosAppScheme>
     */
    public function getIosAppSchemes(): array;
}
