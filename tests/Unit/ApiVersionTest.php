<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Twint\Sdk\ApiVersion;

/**
 * @covers \Twint\Sdk\ApiVersion
 */
final class ApiVersionTest extends TestCase
{
    /**
     * @return iterable<array-key, array{ApiVersion::V_*, int, int, int, string}>
     */
    public static function getExamples(): iterable
    {
        yield [ApiVersion::V8_6_0, 8, 6, 0, '8.6'];
        yield [ApiVersion::V8_5_0, 8, 5, 0, '8.5'];
        yield [80610, 8, 6, 10, '8.6.10']; // @phpstan-ignore-line @psalm-ignore-line
        yield [105010, 10, 50, 10, '10.50.10']; // @phpstan-ignore-line @psalm-ignore-line
    }

    /**
     * @dataProvider getExamples
     * @param ApiVersion::V_* $versionId
     */
    public function testVersionIdToMajor(int $versionId, int $major, int $minor, int $patch, string $version): void
    {
        self::assertSame($major, ApiVersion::major($versionId));
    }

    /**
     * @dataProvider getExamples
     * @param ApiVersion::V_* $versionId
     */
    public function testVersionIdToMinor(int $versionId, int $major, int $minor, int $patch, string $version): void
    {
        self::assertSame($minor, ApiVersion::minor($versionId));
    }

    /**
     * @dataProvider getExamples
     * @param ApiVersion::V_* $versionId
     */
    public function testVersionIdToPatch(int $versionId, int $major, int $minor, int $patch, string $version): void
    {
        self::assertSame($patch, ApiVersion::patch($versionId));
    }

    /**
     * @dataProvider getExamples
     * @param ApiVersion::V_* $versionId
     */
    public function testVersionIdToVersion(int $versionId, int $major, int $minor, int $patch, string $version): void
    {
        self::assertSame($version, ApiVersion::version($versionId));
    }
}
