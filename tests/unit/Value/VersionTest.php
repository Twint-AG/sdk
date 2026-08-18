<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Value;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Twint\Sdk\Value\Url;
use Twint\Sdk\Value\Version;

/**
 * @internal
 */
#[CoversClass(Version::class)]
final class VersionTest extends TestCase
{
    /**
     * @return iterable<array{Version, int, int, int, string, string}>
     */
    public static function getVersionExamples(): iterable
    {
        yield [Version::V8_5_0, 8, 5, 0, '8.5', '8_5'];
        yield [Version::V8_6_0, 8, 6, 0, '8.6', '8_6'];
        yield [Version::V8_7_0, 8, 7, 0, '8.7', '8_7'];
        yield [Version::V9, 9, 0, 0, '9', '9'];
        yield [Version::V10, 10, 0, 0, '10', '10'];
    }

    /**
     * @return iterable<array{Version, Version}>
     */
    public static function getAliasVersions(): iterable
    {
        yield [Version::V10, Version::NEXT];
        yield [Version::V10, Version::LATEST];
    }

    /**
     * @return iterable<array{string, callable(): Url}>
     */
    public static function getNamespaceAccessorExamples(): iterable
    {
        $eightSix = Version::V8_6_0;
        $eightFive = Version::V8_5_0;

        yield ['http://service.twint.ch/base/types/v8_6', $eightSix->soapNamespaceForBaseTypes(...)];
        yield ['http://service.twint.ch/base/types/v8_5', $eightFive->soapNamespaceForBaseTypes(...)];

        yield ['http://service.twint.ch/header/types/v8_6', $eightSix->soapNamespaceForHeaderTypes(...)];
        yield ['http://service.twint.ch/header/types/v8_5', $eightFive->soapNamespaceForHeaderTypes(...)];

        yield ['http://service.twint.ch/common/types/v8_6', $eightSix->soapNamespaceForCommonTypes(...)];
        yield ['http://service.twint.ch/common/types/v8_5', $eightFive->soapNamespaceForCommonTypes(...)];

        yield ['http://service.twint.ch/fault/types/v8_6', $eightSix->soapNamespaceForFaultTypes(...)];
        yield ['http://service.twint.ch/fault/types/v8_5', $eightFive->soapNamespaceForFaultTypes(...)];

        yield ['http://service.twint.ch/merchant/types/v8_6', $eightSix->soapNamespaceForMerchantTypes(...)];
        yield ['http://service.twint.ch/merchant/types/v8_5', $eightFive->soapNamespaceForMerchantTypes(...)];
    }

    #[DataProvider('getVersionExamples')]
    public function testWorkingWithVersionParts(
        Version $version,
        int $major,
        int $minor,
        int $patch,
        string $dotVersion,
        string $underscoreVersion
    ): void {
        self::assertSame($major, $version->major());
        self::assertSame($minor, $version->minor());
        self::assertSame($patch, $version->patch());
        self::assertSame($dotVersion, $version->dotVersion());
        self::assertSame($underscoreVersion, $version->underscoreVersion());
    }

    #[DataProvider('getAliasVersions')]
    public function testNamedConstructors(Version $expected, Version $actual): void
    {
        self::assertSame($expected, $actual);
    }

    /**
     * @param callable(): Url $accessor
     */
    #[DataProvider('getNamespaceAccessorExamples')]
    public function testNamespaceAccessors(string $expectation, callable $accessor): void
    {
        self::assertSame($expectation, (string) $accessor());
    }

    public function testJsonSerialize(): void
    {
        self::assertJsonStringEqualsJsonString('80500', json_encode(Version::V8_5_0, JSON_THROW_ON_ERROR));
    }
}
