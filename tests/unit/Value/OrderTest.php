<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Value;

use PHPUnit\Framework\Attributes\CoversClass;
use Twint\Sdk\Value\FiledMerchantTransactionReference;
use Twint\Sdk\Value\Order;
use Twint\Sdk\Value\OrderId;
use Twint\Sdk\Value\OrderStatus;
use Twint\Sdk\Value\TransactionStatus;
use Twint\Sdk\Value\Uuid;

/**
 * @template-extends ValueTest<Order<null, null>>
 */
#[CoversClass(Order::class)]
final class OrderTest extends ValueTest
{
    protected function createValue(): object
    {
        return new Order(
            new OrderId(new Uuid('12345678-1234-1234-1234-123456789012')),
            new FiledMerchantTransactionReference('1234567890'),
            OrderStatus::FAILURE(),
            TransactionStatus::GENERAL_ERROR(),
        );
    }

    protected static function getValueType(): string
    {
        return Order::class;
    }
}
