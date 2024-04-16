<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Value;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use Twint\Sdk\Value\FiledMerchantTransactionReference;
use Twint\Sdk\Value\Order;
use Twint\Sdk\Value\OrderId;
use Twint\Sdk\Value\OrderStatus;
use Twint\Sdk\Value\PairingStatus;
use Twint\Sdk\Value\PairingToken;
use Twint\Sdk\Value\QrCode;
use Twint\Sdk\Value\TransactionStatus;
use Twint\Sdk\Value\Uuid;

/**
 * @template-extends ValueTest<Order<null, null, null>>
 */
#[CoversClass(Order::class)]
final class OrderTest extends ValueTest
{
    private const ORDER_ID = '12345678-1234-1234-1234-123456789012';

    private const IMAGE = 'data:image/png;base64,123';

    private const MERCHANT_TRANSACTION_REFERENCE = '1234567890';

    private const PAIRING_TOKEN = 1235;

    /**
     * @return iterable<string, array{bool, PairingStatus|null}>
     */
    public static function getPairingRequiredCases(): iterable
    {
        yield 'No pairing status' => [false, null];
        yield 'Pairing status is NO_PAIRING' => [false, PairingStatus::NO_PAIRING()];
        yield 'Pairing status is PAIRING_IN_PROGRESS' => [true, PairingStatus::PAIRING_IN_PROGRESS()];
        yield 'Pairing status is PAIRING_ACTIVE' => [false, PairingStatus::PAIRING_ACTIVE()];
    }

    protected function createValue(): object
    {
        return new Order(
            new OrderId(new Uuid(self::ORDER_ID)),
            new FiledMerchantTransactionReference(self::MERCHANT_TRANSACTION_REFERENCE),
            OrderStatus::FAILURE(),
            TransactionStatus::GENERAL_ERROR(),
        );
    }

    protected static function getValueType(): string
    {
        return Order::class;
    }

    public function testAccessingFields(): void
    {
        $order = new Order(
            new OrderId(new Uuid(self::ORDER_ID)),
            new FiledMerchantTransactionReference(self::MERCHANT_TRANSACTION_REFERENCE),
            OrderStatus::FAILURE(),
            TransactionStatus::GENERAL_ERROR(),
            PairingStatus::PAIRING_IN_PROGRESS(),
            new PairingToken(self::PAIRING_TOKEN),
            new QrCode(self::IMAGE)
        );

        self::assertObjectEquals(OrderId::fromString(self::ORDER_ID), $order->id());
        self::assertObjectEquals(
            new FiledMerchantTransactionReference(self::MERCHANT_TRANSACTION_REFERENCE),
            $order->merchantTransactionReference()
        );
        self::assertObjectEquals(OrderStatus::FAILURE(), $order->status());
        self::assertObjectEquals(TransactionStatus::GENERAL_ERROR(), $order->transactionStatus());
        self::assertObjectEquals(PairingStatus::PAIRING_IN_PROGRESS(), $order->pairingStatus());
        self::assertSame(self::PAIRING_TOKEN, $order->pairingToken()->token());
        self::assertSame(self::IMAGE, (string) $order->qrCode());
    }

    #[DataProvider('getPairingRequiredCases')]
    public function testPairingStatus(bool $expected, ?PairingStatus $pairingStatus): void
    {
        $order = new Order(
            new OrderId(new Uuid(self::ORDER_ID)),
            new FiledMerchantTransactionReference(self::MERCHANT_TRANSACTION_REFERENCE),
            OrderStatus::IN_PROGRESS(),
            TransactionStatus::ORDER_PENDING(),
            $pairingStatus
        );

        self::assertSame($expected, $order->requiresPairing());
    }
}
