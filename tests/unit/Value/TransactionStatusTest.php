<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Value;

use PHPUnit\Framework\Attributes\CoversClass;
use Psl\Type\Exception\AssertException;
use Twint\Sdk\Value\TransactionStatus;

/**
 * @template-extends ValueTest<TransactionStatus>
 * @internal
 */
#[CoversClass(TransactionStatus::class)]
final class TransactionStatusTest extends ValueTest
{
    protected function createValue(): object
    {
        return TransactionStatus::GENERAL_ERROR();
    }

    protected static function getValueType(): string
    {
        return TransactionStatus::class;
    }

    public function testCreateFromInvalidString(): void
    {
        $this->expectException(AssertException::class);

        TransactionStatus::fromString('invalid');
    }

    public function testCreateFromString(): void
    {
        $transactionStatus = TransactionStatus::fromString(TransactionStatus::ORDER_OK);

        self::assertObjectEquals(TransactionStatus::ORDER_OK(), $transactionStatus);
    }
}
