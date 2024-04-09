<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Twint\Sdk\TwintEnvironment;
use Twint\Sdk\TwintVersion;
use Twint\Sdk\Value\File;
use Twint\Sdk\Value\Url;

#[CoversClass(TwintEnvironment::class)]
final class TwintEnvironmentTest extends TestCase
{
    /**
     * @return iterable<array{TwintEnvironment::*}>
     */
    public static function getEnvironmentNames(): iterable
    {
        yield [TwintEnvironment::PRODUCTION];
        yield [TwintEnvironment::TESTING];
    }

    /**
     * @return iterable<array{TwintEnvironment::*, Url}>
     */
    public static function getAppSchemes(): iterable
    {
        yield [TwintEnvironment::PRODUCTION, new Url('https://app.scheme.twint.ch/appSwitch/v1/configs')];
        yield [TwintEnvironment::TESTING, new Url('https://app.scheme-pat.twint.ch/appSwitch/v1/configs')];
    }

    /**
     * @return iterable<array{TwintEnvironment, TwintVersion, Url}>
     */
    public static function getSoapEndpoints(): iterable
    {
        yield [
            TwintEnvironment::PRODUCTION(),
            new TwintVersion(TwintVersion::V8_5_0),
            new Url('https://service.twint.ch/merchant/service/TWINTMerchantServiceV8_5'),
        ];
        yield [
            TwintEnvironment::TESTING(),
            new TwintVersion(TwintVersion::V8_6_0),
            new Url('https://service-pat.twint.ch/merchant/service/TWINTMerchantServiceV8_6'),
        ];
    }

    /**
     * @return iterable<array{TwintEnvironment, TwintVersion, Url}>
     */
    public static function getSoapTargetNamespaces(): iterable
    {
        yield [
            TwintEnvironment::PRODUCTION(),
            new TwintVersion(TwintVersion::V8_5_0),
            new Url('http://service.twint.ch/header/types/v8_5'),
        ];
        yield [
            TwintEnvironment::TESTING(),
            new TwintVersion(TwintVersion::V8_6_0),
            new Url('http://service.twint.ch/header/types/v8_6'),
        ];
    }

    /**
     * @return iterable<array{TwintEnvironment, TwintVersion, File}>
     */
    public static function getSoapWsdlPaths(): iterable
    {
        yield [
            TwintEnvironment::PRODUCTION(),
            new TwintVersion(TwintVersion::V8_5_0),
            new File(__DIR__ . '/../../resources/wsdl/v8.5/TWINTMerchantService_v8.5.wsdl'),
        ];
        yield [
            TwintEnvironment::TESTING(),
            new TwintVersion(TwintVersion::V8_6_0),
            new File(__DIR__ . '/../../resources/wsdl/v8.6/TWINTMerchantService_v8.6.wsdl'),
        ];
    }

    /**
     * @return iterable<array{TwintEnvironment::*, TwintEnvironment}>
     */
    public static function getEnvironments(): iterable
    {
        yield [TwintEnvironment::PRODUCTION, TwintEnvironment::PRODUCTION()];
        yield [TwintEnvironment::TESTING, TwintEnvironment::TESTING()];
    }

    /**
     * @param TwintEnvironment::* $environmentName
     */
    #[DataProvider('getEnvironmentNames')]
    public function testInstantiate(string $environmentName): void
    {
        $environment = new TwintEnvironment($environmentName);

        self::assertSame($environmentName, (string) $environment);
    }

    public function testInvalidEnvironment(): void
    {
        $this->expectExceptionMessage('Expected ""TESTING"|"PRODUCTION"", got "string"');

        /** @phpstan-ignore-next-line */
        new TwintEnvironment('INVALID');
    }

    /**
     * @param TwintEnvironment::* $environmentName
     */
    #[DataProvider('getAppSchemes')]
    public function testEnvironmentSpecificAppSchemeUrls(string $environmentName, Url $appSchemeUrl): void
    {
        $environment = new TwintEnvironment($environmentName);

        self::assertEquals($appSchemeUrl, $environment->appSchemeUrl());
    }

    #[DataProvider('getEnvironments')]
    public function testNamedConstructors(string $environmentName, TwintEnvironment $environment): void
    {
        self::assertSame($environmentName, (string) $environment);
    }

    #[DataProvider('getSoapEndpoints')]
    public function testGetSoapEndpoints(TwintEnvironment $environment, TwintVersion $version, Url $expectedUrl): void
    {
        self::assertEquals($expectedUrl, $environment->soapEndpoint($version));
    }

    #[DataProvider('getSoapTargetNamespaces')]
    public function testGetSoapTargetNamespaces(
        TwintEnvironment $environment,
        TwintVersion $version,
        Url $expectedUrl
    ): void {
        self::assertEquals($expectedUrl, $environment->soapTargetNamespace($version));
    }

    #[DataProvider('getSoapWsdlPaths')]
    public function testSoapWsdlPaths(TwintEnvironment $environment, TwintVersion $version, File $wsdl): void
    {
        self::assertEquals($wsdl, $environment->soapWsdlPath($version));
    }
}
