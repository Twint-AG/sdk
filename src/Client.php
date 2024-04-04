<?php

declare(strict_types=1);

namespace Twint\Sdk;

use Twint\Sdk\Value\CertificateRenewal;
use Twint\Sdk\Value\CertificateValidity;
use Twint\Sdk\Value\DetectedDevice;
use Twint\Sdk\Value\FiledMerchantTransactionReference;
use Twint\Sdk\Value\IosAppScheme;
use Twint\Sdk\Value\Money;
use Twint\Sdk\Value\Order;
use Twint\Sdk\Value\OrderId;
use Twint\Sdk\Value\UnfiledMerchantTransactionReference;

interface Client
{
    public function getCertificateValidity(): CertificateValidity;

    public function renewCertificate(): CertificateRenewal;

    public function startOrder(
        UnfiledMerchantTransactionReference $orderReference,
        Money $requestedAmount,
    ): Order;

    public function monitorOrder(OrderId|FiledMerchantTransactionReference $orderIdOrRef): Order;

    public function confirmOrder(
        OrderId|FiledMerchantTransactionReference $orderIdOrRef,
        Money $requestedAmount
    ): Order;

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
