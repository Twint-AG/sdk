<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Value;

use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use Twint\Sdk\Value\Money;
use Twint\Sdk\Value\ShippingMethod;
use Twint\Sdk\Value\ShippingMethodId;

/**
 * @template-extends ValueTest<ShippingMethod>
 * @internal
 */
#[CoversClass(ShippingMethod::class)]
final class ShippingMethodTest extends ValueTest
{
    #[Override]
    protected function createValue(): object
    {
        return new ShippingMethod(new ShippingMethodId('123'), 'name', Money::CHF(10.00));
    }

    #[Override]
    protected static function getValueType(): string
    {
        return ShippingMethod::class;
    }
}
