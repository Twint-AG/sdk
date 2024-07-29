<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Value;

use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use Twint\Sdk\Value\StoreUuid;
use Twint\Sdk\Value\Uuid;

/**
 * @template-extends ValueTest<StoreUuid>
 * @internal
 */
#[CoversClass(StoreUuid::class)]
final class StoreUuidTest extends ValueTest
{
    private const STORE_UUID_VALUE = '12345678-1234-1234-1234-123456789012';

    public static function testFromString(): void
    {
        $storeUuid = StoreUuid::fromString(self::STORE_UUID_VALUE);

        self::assertSame(self::STORE_UUID_VALUE, (string) $storeUuid);
    }

    #[Override]
    protected function createValue(): object
    {
        return new StoreUuid(new Uuid(self::STORE_UUID_VALUE));
    }

    #[Override]
    protected static function getValueType(): string
    {
        return StoreUuid::class;
    }
}
