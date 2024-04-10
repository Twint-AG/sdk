<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Value;

use PHPUnit\Framework\Attributes\CoversClass;
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
}
