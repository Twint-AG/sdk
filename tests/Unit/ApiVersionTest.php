<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Twint\Sdk\ApiVersion;

#[CoversClass(ApiVersion::class)]
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
     * @param ApiVersion::V_* $versionId
     */
    #[DataProvider('getExamples')]
    public function testVersionIdToMajor(int $versionId, int $major, int $minor, int $patch, string $version): void
    {
        self::assertSame($major, ApiVersion::major($versionId));
    }

    /**
     * @param ApiVersion::V_* $versionId
     */
    #[DataProvider('getExamples')]
    public function testVersionIdToMinor(int $versionId, int $major, int $minor, int $patch, string $version): void
    {
        self::assertSame($minor, ApiVersion::minor($versionId));
    }

    /**
     * @param ApiVersion::V_* $versionId
     */
    #[DataProvider('getExamples')]
    public function testVersionIdToPatch(int $versionId, int $major, int $minor, int $patch, string $version): void
    {
        self::assertSame($patch, ApiVersion::patch($versionId));
    }

    /**
     * @param ApiVersion::V_* $versionId
     */
    #[DataProvider('getExamples')]
    public function testVersionIdToVersion(int $versionId, int $major, int $minor, int $patch, string $version): void
    {
        self::assertSame($version, ApiVersion::version($versionId));
    }
}
