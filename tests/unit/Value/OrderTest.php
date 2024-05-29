<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Value;

use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use Twint\Sdk\Value\FiledMerchantTransactionReference;
use Twint\Sdk\Value\Money;
use Twint\Sdk\Value\NumericPairingToken;
use Twint\Sdk\Value\Order;
use Twint\Sdk\Value\OrderId;
use Twint\Sdk\Value\OrderStatus;
use Twint\Sdk\Value\PairingStatus;
use Twint\Sdk\Value\QrCode;
use Twint\Sdk\Value\TransactionStatus;
use Twint\Sdk\Value\Uuid;

/**
 * @template-extends ValueTest<Order<null, null, null>>
 * @internal
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

    /**
     * @return iterable<string, array{OrderStatus, TransactionStatus, bool, bool, bool, bool, bool}>
     */
    public static function getStatusExamples(): iterable
    {
        yield 'Success' => [OrderStatus::SUCCESS(), TransactionStatus::ORDER_OK(), true, false, false, false, false];
        yield 'Failure' => [
            OrderStatus::FAILURE(),
            TransactionStatus::CLIENT_ABORT(),
            false,
            true,
            false,
            false,
            false,
        ];
        yield 'In progress 1' => [
            OrderStatus::IN_PROGRESS(),
            TransactionStatus::ORDER_PENDING(),
            false,
            false,
            true,
            true,
            false,
        ];
        yield 'In progress 2' => [
            OrderStatus::IN_PROGRESS(),
            TransactionStatus::ORDER_RECEIVED(),
            false,
            false,
            true,
            true,
            false,
        ];
        yield 'Confirmation required' => [
            OrderStatus::IN_PROGRESS(),
            TransactionStatus::ORDER_CONFIRMATION_PENDING(),
            false,
            false,
            true,
            false,
            true,
        ];
    }

    #[Override]
    protected function createValue(): object
    {
        return new Order(
            new OrderId(new Uuid(self::ORDER_ID)),
            new FiledMerchantTransactionReference(self::MERCHANT_TRANSACTION_REFERENCE),
            OrderStatus::FAILURE(),
            TransactionStatus::GENERAL_ERROR(),
            Money::CHF(0.20),
        );
    }

    #[Override]
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
            Money::CHF(0.21),
            PairingStatus::PAIRING_IN_PROGRESS(),
            new NumericPairingToken(self::PAIRING_TOKEN),
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
            Money::CHF(0.20),
            $pairingStatus
        );

        self::assertSame($expected, $order->requiresPairing());
    }

    #[DataProvider('getStatusExamples')]
    public function testStatus(
        OrderStatus $status,
        TransactionStatus $transactionStatus,
        bool $isSuccessful,
        bool $isFailure,
        bool $isPending,
        bool $userInteractionRequired,
        bool $confirmationPending
    ): void {
        $order = new Order(
            new OrderId(new Uuid(self::ORDER_ID)),
            new FiledMerchantTransactionReference(self::MERCHANT_TRANSACTION_REFERENCE),
            $status,
            $transactionStatus,
            Money::CHF(0.20)
        );

        self::assertSame($isSuccessful, $order->isSuccessful());
        self::assertSame($isFailure, $order->isFailure());
        self::assertSame($isPending, $order->isPending());
        self::assertSame($userInteractionRequired, $order->userInteractionRequired());
        self::assertSame($confirmationPending, $order->isConfirmationPending());
    }

    public function testAccessAmount(): void
    {
        $order = new Order(
            new OrderId(new Uuid(self::ORDER_ID)),
            new FiledMerchantTransactionReference(self::MERCHANT_TRANSACTION_REFERENCE),
            OrderStatus::FAILURE(),
            TransactionStatus::GENERAL_ERROR(),
            Money::CHF(0.21),
        );

        self::assertObjectEquals(Money::CHF(0.21), $order->amount());
    }
}
