<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use Twint\Sdk\Tests\Unit\Value\ValueTest;
use Twint\Sdk\TwintVersion;

/**
 * @phpstan-import-type ExistingVersionId from TwintVersion
 * @phpstan-import-type VersionId from TwintVersion
 * @template-extends ValueTest<TwintVersion>
 */
#[CoversClass(TwintVersion::class)]
final class TwintVersionTest extends ValueTest
{
    /**
     * @return iterable<array{VersionId}>
     */
    public static function getVersionIds(): iterable
    {
        yield [TwintVersion::V8_5_0];
        yield [TwintVersion::V8_6_0];
        yield [10_16_01];
    }

    /**
     * @return iterable<array{VersionId, int, int, int, string, string}>
     */
    public static function getVersionExamples(): iterable
    {
        yield [TwintVersion::V8_5_0, 8, 5, 0, '8.5', '8_5'];
        yield [TwintVersion::V8_6_0, 8, 6, 0, '8.6', '8_6'];
        yield [10_16_01, 10, 16, 1, '10.16.1', '10_16_1'];
    }

    /**
     * @return iterable<array{VersionId, TwintVersion}>
     */
    public static function getAliasVersions(): iterable
    {
        yield [TwintVersion::V8_6_0, TwintVersion::next()];
        yield [TwintVersion::V8_5_0, TwintVersion::latest()];
    }

    /**
     * @param VersionId $versionId
     */
    #[DataProvider('getVersionIds')]
    public function testInstantiation(int $versionId): void
    {
        $version = new TwintVersion($versionId);

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
        $version = new TwintVersion($versionId);

        self::assertSame($versionId, $version->id());
        self::assertSame($major, $version->major());
        self::assertSame($minor, $version->minor());
        self::assertSame($patch, $version->patch());
        self::assertSame($dotVersion, $version->dotVersion());
        self::assertSame($underscoreVersion, $version->underscoreVersion());
    }

    #[DataProvider('getAliasVersions')]
    public function testNamedConstructors(int $versionId, TwintVersion $version): void
    {
        self::assertSame($versionId, $version->id());
    }

    protected function createValue(): object
    {
        return TwintVersion::latest();
    }

    protected static function getValueType(): string
    {
        return TwintVersion::class;
    }
}
