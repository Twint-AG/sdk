<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Value;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Twint\Sdk\Value\OrderStatus;
use ValueError;

/**
 * @internal
 */
#[CoversClass(OrderStatus::class)]
final class OrderStatusTest extends TestCase
{
    public function testCreateFromInvalidString(): void
    {
        $this->expectException(ValueError::class);

        OrderStatus::from('INVALID_STATUS');
    }

    public function testCreateFromString(): void
    {
        self::assertSame(OrderStatus::IN_PROGRESS, OrderStatus::from('IN_PROGRESS'));
    }

    public function testJsonSerialize(): void
    {
        self::assertJsonStringEqualsJsonString('"SUCCESS"', json_encode(OrderStatus::SUCCESS, JSON_THROW_ON_ERROR));
    }
}
