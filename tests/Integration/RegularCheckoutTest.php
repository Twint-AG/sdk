<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Integration;

use Twint\Sdk\Checks\PHPUnit\IntegrationTest;
use Twint\Sdk\Value\Money;
use Twint\Sdk\Value\OrderKind;
use Twint\Sdk\Value\OrderStatus;

/**
 * @covers \Twint\Sdk\ApiClient::startOrder
 */
final class RegularCheckoutTest extends IntegrationTest
{
    public function testStartMinimalOrder(): void
    {
        $order = $this->client->startOrder(
            self::getMerchantId(),
            Money::CHF(100),
            OrderKind::PAYMENT_IMMEDIATE(),
            self::createTransactionReference()
        );

        self::assertSame(OrderStatus::IN_PROGRESS, (string) $order->status());
    }

    public function testMonitorOrderByOrderId(): void
    {
        $transactionReference = self::createTransactionReference();

        $order = $this->client->startOrder(
            self::getMerchantId(),
            Money::CHF(100),
            OrderKind::PAYMENT_IMMEDIATE(),
            $transactionReference
        );

        $monitorOrder = $this->client->monitorOrderByOrderId(self::getMerchantId(), $order->id());

        self::assertTrue($order->equals($monitorOrder));
    }

    public function testMonitorOrderByTransactionReference(): void
    {
        $transactionReference = self::createTransactionReference();

        $order = $this->client->startOrder(
            self::getMerchantId(),
            Money::CHF(100),
            OrderKind::PAYMENT_IMMEDIATE(),
            $transactionReference
        );

        $monitorOrder = $this->client->monitorOrderByTransactionReference(self::getMerchantId(), $transactionReference);

        self::assertTrue($order->equals($monitorOrder));
    }
}
