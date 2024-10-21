<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Value;

use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use Twint\Sdk\Value\ShopPlatform;

/**
 * @template-extends ValueTest<ShopPlatform>
 * @internal
 */
#[CoversClass(ShopPlatform::class)]
final class ShopPlatformTest extends ValueTest
{
    protected bool $constNamesEqualsValues = false;

    #[Override]
    protected function createValue(): object
    {
        return ShopPlatform::MAGENTO();
    }

    #[Override]
    protected static function getValueType(): string
    {
        return ShopPlatform::class;
    }
}
