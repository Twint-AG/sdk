<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Value;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Twint\Sdk\Value\OrderKind;

/**
 * @covers \Twint\Sdk\Value\OrderKind
 */
final class OrderKindTest extends TestCase
{
    public function testItCanBeCreated(): void
    {
        $orderKind = OrderKind::PAYMENT_IMMEDIATE();
        self::assertSame('PAYMENT_IMMEDIATE', (string) $orderKind);
    }

    public function testCreateWithInvalidValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            '"INVALID" is not a order kind. Supported: PAYMENT_IMMEDIATE, PAYMENT_DEFERRED, PAYMENT_RECURRING, REVERSAL, CREDIT'
        );
        new OrderKind('INVALID');
    }
}
