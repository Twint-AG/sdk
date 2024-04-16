<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Value;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use Twint\Sdk\Value\Version;

/**
 * @phpstan-import-type ExistingVersionId from Version
 * @phpstan-import-type VersionId from Version
 * @template-extends ValueTest<Version>
 */
#[CoversClass(Version::class)]
final class VersionTest extends ValueTest
{
    /**
     * @return iterable<array{VersionId}>
     */
    public static function getVersionIds(): iterable
    {
        yield [Version::V8_5_0];
        yield [Version::V8_6_0];
        yield [10_16_01];
    }

    /**
     * @return iterable<array{VersionId, int, int, int, string, string}>
     */
    public static function getVersionExamples(): iterable
    {
        yield [Version::V8_5_0, 8, 5, 0, '8.5', '8_5'];
        yield [Version::V8_6_0, 8, 6, 0, '8.6', '8_6'];
        yield [10_16_01, 10, 16, 1, '10.16.1', '10_16_1'];
    }

    /**
     * @return iterable<array{VersionId, Version}>
     */
    public static function getAliasVersions(): iterable
    {
        yield [Version::V8_6_0, Version::next()];
        yield [Version::V8_5_0, Version::latest()];
    }

    /**
     * @param VersionId $versionId
     */
    #[DataProvider('getVersionIds')]
    public function testInstantiation(int $versionId): void
    {
        $version = new Version($versionId);

        self::assertSame($versionId, $version->id());
    }

    /**
     * @param VersionId $versionId
     */
    #[DataProvider('getVersionExamples')]
    public function testWorkingWithVersionParts(
        int $versionId,
        int $major,
        int $minor,
        int $patch,
        string $dotVersion,
        string $underscoreVersion
    ): void {
        $version = new Version($versionId);

        self::assertSame($versionId, $version->id());
        self::assertSame($major, $version->major());
        self::assertSame($minor, $version->minor());
        self::assertSame($patch, $version->patch());
        self::assertSame($dotVersion, $version->dotVersion());
        self::assertSame($underscoreVersion, $version->underscoreVersion());
    }

    #[DataProvider('getAliasVersions')]
    public function testNamedConstructors(int $versionId, Version $version): void
    {
        self::assertSame($versionId, $version->id());
    }

    protected function createValue(): object
    {
        return Version::latest();
    }

    protected static function getValueType(): string
    {
        return Version::class;
    }
}
