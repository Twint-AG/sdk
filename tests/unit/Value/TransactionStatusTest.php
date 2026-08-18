<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Value;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Twint\Sdk\Value\TransactionStatus;
use ValueError;

/**
 * @internal
 */
#[CoversClass(TransactionStatus::class)]
final class TransactionStatusTest extends TestCase
{
    public function testCreateFromInvalidString(): void
    {
        $this->expectException(ValueError::class);

        TransactionStatus::from('invalid');
    }

    public function testCreateFromString(): void
    {
        self::assertSame(TransactionStatus::ORDER_OK, TransactionStatus::from('ORDER_OK'));
    }

    public function testJsonSerialize(): void
    {
        self::assertJsonStringEqualsJsonString(
            '"ORDER_OK"',
            json_encode(TransactionStatus::ORDER_OK, JSON_THROW_ON_ERROR)
        );
    }
}
