<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Value;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Twint\Sdk\Value\ShopPlatform;
use ValueError;

/**
 * @internal
 */
#[CoversClass(ShopPlatform::class)]
final class ShopPlatformTest extends TestCase
{
    public function testWireValuesAreStable(): void
    {
        self::assertSame('mg', ShopPlatform::MAGENTO->value);
        self::assertSame('sw', ShopPlatform::SHOPWARE->value);
        self::assertSame('wc', ShopPlatform::WOOCOMMERCE->value);
        self::assertSame('ot', ShopPlatform::OTHER->value);
    }

    public function testCreateFromInvalidString(): void
    {
        $this->expectException(ValueError::class);

        ShopPlatform::from('invalid');
    }

    public function testJsonSerialize(): void
    {
        self::assertJsonStringEqualsJsonString('"mg"', json_encode(ShopPlatform::MAGENTO, JSON_THROW_ON_ERROR));
    }
}
