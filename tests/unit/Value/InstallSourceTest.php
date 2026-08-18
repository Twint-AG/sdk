<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Value;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Twint\Sdk\Value\InstallSource;
use ValueError;

/**
 * @internal
 */
#[CoversClass(InstallSource::class)]
final class InstallSourceTest extends TestCase
{
    public function testWireValuesAreStable(): void
    {
        self::assertSame('D', InstallSource::DIRECT->value);
        self::assertSame('S', InstallSource::STORE->value);
    }

    public function testCreateFromInvalidString(): void
    {
        $this->expectException(ValueError::class);

        InstallSource::from('invalid');
    }

    public function testJsonSerialize(): void
    {
        self::assertJsonStringEqualsJsonString('"D"', json_encode(InstallSource::DIRECT, JSON_THROW_ON_ERROR));
    }
}
