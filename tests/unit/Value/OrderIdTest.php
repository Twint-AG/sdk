<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Value;

use PHPUnit\Framework\Attributes\CoversClass;
use Twint\Sdk\Value\OrderId;
use Twint\Sdk\Value\Uuid;

/**
 * @template-extends ValueTest<OrderId>
 * @internal
 */
#[CoversClass(OrderId::class)]
final class OrderIdTest extends ValueTest
{
    private const UUID = '12345678-1234-1234-1234-123456789012';

    public static function testFromString(): void
    {
        $orderId = OrderId::fromString(self::UUID);
        self::assertSame(self::UUID, (string) $orderId);
    }

    protected function createValue(): object
    {
        return new OrderId(new Uuid(self::UUID));
    }

    protected static function getValueType(): string
    {
        return OrderId::class;
    }
}
