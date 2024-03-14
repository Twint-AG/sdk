<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Integration;

use PHPUnit\Framework\TestCase;
use Twint\Sdk\ApiClient;
use Twint\Sdk\Certificate;
use Twint\Sdk\Value\MerchantId;
use Twint\Sdk\Value\Money;
use Twint\Sdk\Value\OrderKind;
use Twint\Sdk\Value\OrderStatus;
use Twint\Sdk\Value\TransactionReference;

/**
 * @covers \Twint\Sdk\ApiClient::startOrder
 */
final class StartOrderTest extends TestCase
{
    private ApiClient $client;

    protected function setUp(): void
    {
        $this->client = new ApiClient(
            new Certificate($_SERVER['TWINT_SDK_TEST_CERT_P12_PATH'], $_SERVER['TWINT_SDK_TEST_CERT_P12_PASSPHRASE'])
        );
    }

    public function testStartMinimalOrder(): void
    {
        $order = $this->client->startOrder(
            MerchantId::fromString($_SERVER['TWINT_SDK_TEST_MERCHANT_ID']),
            Money::CHF(100),
            OrderKind::PAYMENT_IMMEDIATE(),
            new TransactionReference('1234')
        );

        self::assertSame(OrderStatus::IN_PROGRESS, (string) $order->status());
    }
}
