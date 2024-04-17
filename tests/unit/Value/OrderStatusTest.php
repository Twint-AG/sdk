<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Value;

use PHPUnit\Framework\Attributes\CoversClass;
use Psl\Type\Exception\AssertException;
use Twint\Sdk\Value\OrderStatus;

/**
 * @template-extends ValueTest<OrderStatus>
 */
#[CoversClass(OrderStatus::class)]
final class OrderStatusTest extends ValueTest
{
    protected function createValue(): object
    {
        return OrderStatus::FAILURE();
    }

    protected static function getValueType(): string
    {
        return OrderStatus::class;
    }

    public function testCreateFromInvalidString(): void
    {
        $this->expectException(AssertException::class);

        OrderStatus::fromString('INVALID_STATUS');
    }

    public function testCreateFromString(): void
    {
        $orderStatus = OrderStatus::fromString('IN_PROGRESS');

        self::assertObjectEquals(OrderStatus::IN_PROGRESS(), $orderStatus);
    }
}
