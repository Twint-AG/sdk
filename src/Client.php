<?php

declare(strict_types=1);

namespace Twint\Sdk;

use Twint\Sdk\Value\CertificateRenewal;
use Twint\Sdk\Value\CertificateValidity;
use Twint\Sdk\Value\DetectedDevice;
use Twint\Sdk\Value\IosAppScheme;
use Twint\Sdk\Value\MerchantId;
use Twint\Sdk\Value\Money;
use Twint\Sdk\Value\Order;
use Twint\Sdk\Value\OrderId;
use Twint\Sdk\Value\OrderKind;
use Twint\Sdk\Value\TransactionReference;

interface Client
{
    public function getCertificateValidity(MerchantId $merchantId): CertificateValidity;

    public function renewCertificate(MerchantId $merchantId): CertificateRenewal;

    public function startOrder(
        MerchantId $merchantId,
        Money $requestedAmount,
        OrderKind $orderKind,
        TransactionReference $transactionReference,
    ): Order;

    public function monitorOrderByOrderId(MerchantId $merchantId, OrderId $orderId): Order;

    public function monitorOrderByTransactionReference(
        MerchantId $merchantId,
        TransactionReference $transactionReference
    ): Order;

    public function confirmOrderByOrderId(MerchantId $merchantId, OrderId $orderId, Money $requestedAmount): Order;

    public function confirmOrderByTransactionReference(
        MerchantId $merchantId,
        TransactionReference $transactionReference,
        Money $requestedAmount
    ): Order;

    public function detectDevice(string $userAgent): DetectedDevice;

    /**
     * @return list<IosAppScheme>
     */
    public function getIosAppSchemes(): array;
}
