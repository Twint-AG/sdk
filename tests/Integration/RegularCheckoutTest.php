<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Integration;

use PHPUnit\Framework\Attributes\CoversClass;
use Twint\Sdk\ApiClient;
use Twint\Sdk\Checks\PHPUnit\IntegrationTest;
use Twint\Sdk\Checks\PHPUnit\Vcr;
use Twint\Sdk\Value\Money;
use Twint\Sdk\Value\OrderStatus;

#[CoversClass(ApiClient::class)]
final class RegularCheckoutTest extends IntegrationTest
{
    #[Vcr(fixtureRevision: 10, requestMatchers: self::SOAP_REQUEST_MATCHERS)]
    public function testStartOrder(): void
    {
        $order = $this->client->startOrder(
            self::getMerchantId(),
            $this->createTransactionReference(),
            Money::CHF(100)
        );

        self::assertSame(OrderStatus::IN_PROGRESS, (string) $order->status());
    }

    #[Vcr(fixtureRevision: 10, requestMatchers: self::SOAP_REQUEST_MATCHERS)]
    public function testMonitorOrderByOrderId(): void
    {
        $transactionReference = $this->createTransactionReference();

        $order = $this->client->startOrder(self::getMerchantId(), $transactionReference, Money::CHF(100));

        $monitorOrder = $this->client->monitorOrder(self::getMerchantId(), $order->id());

        self::assertTrue($order->equals($monitorOrder));
    }

    #[Vcr(fixtureRevision: 10, requestMatchers: self::SOAP_REQUEST_MATCHERS)]
    public function testMonitorOrderByMerchantTransactionReference(): void
    {
        $transactionReference = $this->createTransactionReference();

        $order = $this->client->startOrder(self::getMerchantId(), $transactionReference, Money::CHF(100));

        $monitorOrder = $this->client->monitorOrder(self::getMerchantId(), $order->merchantTransactionReference());

        self::assertTrue($order->equals($monitorOrder));
    }

    #[Vcr(fixtureRevision: 1, requestMatchers: self::SOAP_REQUEST_MATCHERS)]
    public function testConfirmOrderByOrderId(): void
    {
        $transactionReference = $this->createTransactionReference();

        $order = $this->client->startOrder(self::getMerchantId(), $transactionReference, Money::CHF(100));

        $confirmedOrder = $this->client->confirmOrder(self::getMerchantId(), $order->id(), Money::CHF(100));

        self::assertTrue($confirmedOrder->status()->equals(OrderStatus::SUCCESS()));
    }

    #[Vcr(fixtureRevision: 1, requestMatchers: self::SOAP_REQUEST_MATCHERS)]
    public function testConfirmOrderByMerchantTransactionReference(): void
    {
        $transactionReference = $this->createTransactionReference();

        $order = $this->client->startOrder(self::getMerchantId(), $transactionReference, Money::CHF(100));

        $confirmedOrder = $this->client->confirmOrder(
            self::getMerchantId(),
            $order->merchantTransactionReference(),
            Money::CHF(100)
        );

        self::assertTrue($confirmedOrder->status()->equals(OrderStatus::SUCCESS()));
    }

    #[Vcr(fixtureRevision: 2, requestMatchers: self::SOAP_REQUEST_MATCHERS)]
    public function testReverseOrderByOrderId(): void
    {
        $transactionReference = $this->createTransactionReference();

        $order = $this->client->startOrder(self::getMerchantId(), $transactionReference, Money::CHF(100));

        $reversalReference = $this->createTransactionReference();
        $reversed = $this->client->reverseOrder(
            self::getMerchantId(),
            $reversalReference,
            Money::CHF(100),
            $order->id()
        );

        self::assertFalse($order->merchantTransactionReference()->equals($reversed->merchantTransactionReference()));
    }

    #[Vcr(fixtureRevision: 2, requestMatchers: self::SOAP_REQUEST_MATCHERS)]
    public function testReverseOrderByMerchantTransactionReference(): void
    {
        $transactionReference = $this->createTransactionReference();

        $order = $this->client->startOrder(self::getMerchantId(), $transactionReference, Money::CHF(100));

        $reversalReference = $this->createTransactionReference();
        $reversed = $this->client->reverseOrder(
            self::getMerchantId(),
            $reversalReference,
            Money::CHF(100),
            $order->merchantTransactionReference()
        );

        self::assertFalse($order->merchantTransactionReference()->equals($reversed->merchantTransactionReference()));
    }
}
