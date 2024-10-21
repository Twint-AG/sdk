<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Value;

use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use Twint\Sdk\Value\PlatformVersion;

/**
 * @template-extends ValueTest<PlatformVersion>
 * @internal
 */
#[CoversClass(PlatformVersion::class)]
final class PlatformVersionTest extends ValueTest
{
    public static function testMultiple(): void
    {
        $version = PlatformVersion::multiple('1.2', '2.0');

        self::assertSame('1.2,2.0', (string) $version);
    }

    #[Override]
    protected function createValue(): object
    {
        return new PlatformVersion('1.2.3');
    }

    #[Override]
    protected static function getValueType(): string
    {
        return PlatformVersion::class;
    }
}
