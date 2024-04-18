<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Value;

use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use Twint\Sdk\Value\MerchantId;
use Twint\Sdk\Value\Uuid;

/**
 * @template-extends ValueTest<MerchantId>
 * @internal
 */
#[CoversClass(MerchantId::class)]
final class MerchantIdTest extends ValueTest
{
    private const MERCHANT_ID_VALUE = '12345678-1234-1234-1234-123456789012';

    public static function testFromString(): void
    {
        $merchantId = MerchantId::fromString(self::MERCHANT_ID_VALUE);

        self::assertSame(self::MERCHANT_ID_VALUE, (string) $merchantId);
    }

    #[Override]
    protected function createValue(): object
    {
        return new MerchantId(new Uuid(self::MERCHANT_ID_VALUE));
    }

    #[Override]
    protected static function getValueType(): string
    {
        return MerchantId::class;
    }
}
