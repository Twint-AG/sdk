<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Value;

use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use Twint\Sdk\Value\ShippingMethodId;

/**
 * @template-extends ValueTest<ShippingMethodId>
 * @internal
 */
#[CoversClass(ShippingMethodId::class)]
final class ShippingMethodIdTest extends ValueTest
{
    #[Override]
    protected function createValue(): object
    {
        return new ShippingMethodId('123');
    }

    #[Override]
    protected static function getValueType(): string
    {
        return ShippingMethodId::class;
    }
}
