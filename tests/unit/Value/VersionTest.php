<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Value;

use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use Twint\Sdk\Value\Url;
use Twint\Sdk\Value\Version;

/**
 * @phpstan-import-type ExistingVersionId from Version
 * @phpstan-import-type VersionId from Version
 * @template-extends ValueTest<Version>
 * @internal
 */
#[CoversClass(Version::class)]
final class VersionTest extends ValueTest
{
    protected bool $constNamesEqualsValues = false;

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
     * @return iterable<array{string, callable(): Url}>
     */
    public static function getNamespaceAccessorExamples(): iterable
    {
        $latest = Version::latest();
        $next = Version::next();

        yield ['http://service.twint.ch/base/types/v8_5', $latest->soapNamespaceForBaseTypes(...)];
        yield ['http://service.twint.ch/base/types/v8_6', $next->soapNamespaceForBaseTypes(...)];

        yield ['http://service.twint.ch/header/types/v8_5', $latest->soapNamespaceForHeaderTypes(...)];
        yield ['http://service.twint.ch/header/types/v8_6', $next->soapNamespaceForHeaderTypes(...)];

        yield ['http://service.twint.ch/common/types/v8_5', $latest->soapNamespaceForCommonTypes(...)];
        yield ['http://service.twint.ch/common/types/v8_6', $next->soapNamespaceForCommonTypes(...)];

        yield ['http://service.twint.ch/fault/types/v8_5', $latest->soapNamespaceForFaultTypes(...)];
        yield ['http://service.twint.ch/fault/types/v8_6', $next->soapNamespaceForFaultTypes(...)];

        yield ['http://service.twint.ch/merchant/types/v8_5', $latest->soapNamespaceForMerchantTypes(...)];
        yield ['http://service.twint.ch/merchant/types/v8_6', $next->soapNamespaceForMerchantTypes(...)];
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

    /**
     * @param callable(): Url $accessor
     */
    #[DataProvider('getNamespaceAccessorExamples')]
    public function testNamespaceAccessors(string $expectation, callable $accessor): void
    {
        self::assertSame($expectation, (string) $accessor());
    }

    #[Override]
    protected function createValue(): object
    {
        return Version::latest();
    }

    #[Override]
    protected static function getValueType(): string
    {
        return Version::class;
    }
}
