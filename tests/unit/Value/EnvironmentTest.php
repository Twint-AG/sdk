<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Value;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Twint\Sdk\Value\Environment;
use Twint\Sdk\Value\ExistingPath;
use Twint\Sdk\Value\Url;
use Twint\Sdk\Value\Version;
use ValueError;

/**
 * @internal
 */
#[CoversClass(Environment::class)]
final class EnvironmentTest extends TestCase
{
    /**
     * @return iterable<array{Environment, Url}>
     */
    public static function getAppSchemes(): iterable
    {
        yield [Environment::PRODUCTION, new Url('https://app.scheme.twint.ch/appSwitch/v1/configs')];
        yield [Environment::TESTING, new Url('https://app.scheme-pat.twint.ch/appSwitch/v1/configs')];
    }

    /**
     * @return iterable<array{Environment, Version, Url}>
     */
    public static function getSoapEndpoints(): iterable
    {
        yield [
            Environment::PRODUCTION,
            Version::V8_5_0,
            new Url('https://service.twint.ch/merchant/service/TWINTMerchantServiceV8_5'),
        ];
        yield [
            Environment::TESTING,
            Version::V8_6_0,
            new Url('https://service-pat.twint.ch/merchant/service/TWINTMerchantServiceV8_6'),
        ];
    }

    /**
     * @return iterable<array{Environment, Version, ExistingPath}>
     */
    public static function getSoapWsdlPaths(): iterable
    {
        yield [
            Environment::PRODUCTION,
            Version::V8_5_0,
            new ExistingPath(__DIR__ . '/../../../resources/wsdl/v8.5/TWINTMerchantService_v8.5.wsdl'),
        ];
        yield [
            Environment::TESTING,
            Version::V8_6_0,
            new ExistingPath(__DIR__ . '/../../../resources/wsdl/v8.6/TWINTMerchantService_v8.6.wsdl'),
        ];
    }

    public function testFrom(): void
    {
        self::assertSame(Environment::TESTING, Environment::from('TESTING'));
        self::assertSame(Environment::PRODUCTION, Environment::from('PRODUCTION'));
    }

    public function testInvalidEnvironment(): void
    {
        $this->expectException(ValueError::class);

        Environment::from('INVALID');
    }

    public function testJsonSerialize(): void
    {
        self::assertJsonStringEqualsJsonString('"TESTING"', json_encode(Environment::TESTING, JSON_THROW_ON_ERROR));
        self::assertJsonStringEqualsJsonString(
            '"PRODUCTION"',
            json_encode(Environment::PRODUCTION, JSON_THROW_ON_ERROR)
        );
    }

    #[DataProvider('getAppSchemes')]
    public function testEnvironmentSpecificAppSchemeUrls(Environment $environment, Url $appSchemeUrl): void
    {
        self::assertObjectEquals($appSchemeUrl, $environment->appSchemeUrl());
    }

    #[DataProvider('getSoapEndpoints')]
    public function testGetSoapEndpoints(Environment $environment, Version $version, Url $expectedUrl): void
    {
        self::assertObjectEquals($expectedUrl, $environment->soapEndpoint($version));
    }

    #[DataProvider('getSoapWsdlPaths')]
    public function testSoapWsdlPaths(Environment $environment, Version $version, ExistingPath $wsdl): void
    {
        self::assertObjectEquals($wsdl, $environment->soapWsdlPath($version));
    }
}
