<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Integration;

use PHPUnit\Framework\Attributes\CoversClass;
use Twint\Sdk\ApiClient;
use Twint\Sdk\Checks\PHPUnit\IntegrationTest;
use Twint\Sdk\Checks\PHPUnit\Vcr;
use Twint\Sdk\Value\Money;
use Twint\Sdk\Value\OrderStatus;
use Twint\Sdk\Value\PairingStatus;

#[CoversClass(ApiClient::class)]
final class RegularCheckoutTest extends IntegrationTest
{
    #[Vcr(fixtureRevision: 10, requestMatchers: self::SOAP_REQUEST_MATCHERS)]
    public function testStartOrder(): void
    {
        $order = $this->client->startOrder($this->createTransactionReference(), Money::CHF(100));

        self::assertSame(OrderStatus::IN_PROGRESS, (string) $order->status());
        self::assertTrue($order->requiresPairing());
        self::assertNotNull($order->pairingStatus());
        self::assertTrue(PairingStatus::PAIRING_IN_PROGRESS()->equals($order->pairingStatus()));
        self::assertNotNull($order->pairingToken());
    }

    #[Vcr(fixtureRevision: 10, requestMatchers: self::SOAP_REQUEST_MATCHERS)]
    public function testMonitorOrderByOrderId(): void
    {
        $transactionReference = $this->createTransactionReference();

        $order = $this->client->startOrder($transactionReference, Money::CHF(100));

        $monitorOrder = $this->client->monitorOrder($order->id());

        self::assertTrue($order->id()->equals($monitorOrder->id()));
        self::assertTrue($order->transactionStatus()->equals($monitorOrder->transactionStatus()));
        self::assertTrue($order->pairingStatus()->equals($monitorOrder->pairingStatus()));
    }

    #[Vcr(fixtureRevision: 10, requestMatchers: self::SOAP_REQUEST_MATCHERS)]
    public function testMonitorOrderByMerchantTransactionReference(): void
    {
        $transactionReference = $this->createTransactionReference();

        $order = $this->client->startOrder($transactionReference, Money::CHF(100));

        $monitorOrder = $this->client->monitorOrder($order->merchantTransactionReference());

        self::assertTrue($order->id()->equals($monitorOrder->id()));
        self::assertTrue($order->transactionStatus()->equals($monitorOrder->transactionStatus()));
        self::assertTrue($order->pairingStatus()->equals($monitorOrder->pairingStatus()));
    }

    #[Vcr(fixtureRevision: 1, requestMatchers: self::SOAP_REQUEST_MATCHERS)]
    public function testConfirmOrderByOrderId(): void
    {
        $transactionReference = $this->createTransactionReference();

        $order = $this->client->startOrder($transactionReference, Money::CHF(100));

        $confirmedOrder = $this->client->confirmOrder($order->id(), Money::CHF(100));

        self::assertTrue($confirmedOrder->status()->equals(OrderStatus::SUCCESS()));
    }

    #[Vcr(fixtureRevision: 1, requestMatchers: self::SOAP_REQUEST_MATCHERS)]
    public function testConfirmOrderByMerchantTransactionReference(): void
    {
        $transactionReference = $this->createTransactionReference();

        $order = $this->client->startOrder($transactionReference, Money::CHF(100));

        $confirmedOrder = $this->client->confirmOrder($order->merchantTransactionReference(), Money::CHF(100));

        self::assertTrue($confirmedOrder->status()->equals(OrderStatus::SUCCESS()));
    }

    #[Vcr(fixtureRevision: 2, requestMatchers: self::SOAP_REQUEST_MATCHERS)]
    public function testReverseOrderByOrderId(): void
    {
        $transactionReference = $this->createTransactionReference();

        $order = $this->client->startOrder($transactionReference, Money::CHF(100));

        $reversalReference = $this->createTransactionReference();
        $reversed = $this->client->reverseOrder($reversalReference, $order->id(), Money::CHF(100));

        self::assertFalse($order->merchantTransactionReference()->equals($reversed->merchantTransactionReference()));
        self::assertFalse($reversed->requiresPairing());
    }

    #[Vcr(fixtureRevision: 2, requestMatchers: self::SOAP_REQUEST_MATCHERS)]
    public function testReverseOrderByMerchantTransactionReference(): void
    {
        $transactionReference = $this->createTransactionReference();

        $order = $this->client->startOrder($transactionReference, Money::CHF(100));

        $reversalReference = $this->createTransactionReference();
        $reversed = $this->client->reverseOrder(
            $reversalReference,
            $order->merchantTransactionReference(),
            Money::CHF(100)
        );

        self::assertFalse($order->merchantTransactionReference()->equals($reversed->merchantTransactionReference()));
        self::assertFalse($reversed->requiresPairing());
        self::assertNull($reversed->pairingToken());
    }
}
