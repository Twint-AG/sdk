<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Value;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use Twint\Sdk\Value\Environment;
use Twint\Sdk\Value\File;
use Twint\Sdk\Value\Url;
use Twint\Sdk\Value\Version;

/**
 * @template-extends ValueTest<Environment>
 */
#[CoversClass(Environment::class)]
final class EnvironmentTest extends ValueTest
{
    /**
     * @return iterable<array{Environment::*}>
     */
    public static function getEnvironmentNames(): iterable
    {
        yield [Environment::PRODUCTION];
        yield [Environment::TESTING];
    }

    /**
     * @return iterable<array{Environment::*, Url}>
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
            Environment::PRODUCTION(),
            new Version(Version::V8_5_0),
            new Url('https://service.twint.ch/merchant/service/TWINTMerchantServiceV8_5'),
        ];
        yield [
            Environment::TESTING(),
            new Version(Version::V8_6_0),
            new Url('https://service-pat.twint.ch/merchant/service/TWINTMerchantServiceV8_6'),
        ];
    }

    /**
     * @return iterable<array{Environment, Version, Url}>
     */
    public static function getSoapTargetNamespaces(): iterable
    {
        yield [
            Environment::PRODUCTION(),
            new Version(Version::V8_5_0),
            new Url('http://service.twint.ch/header/types/v8_5'),
        ];
        yield [
            Environment::TESTING(),
            new Version(Version::V8_6_0),
            new Url('http://service.twint.ch/header/types/v8_6'),
        ];
    }

    /**
     * @return iterable<array{Environment, Version, File}>
     */
    public static function getSoapWsdlPaths(): iterable
    {
        yield [
            Environment::PRODUCTION(),
            new Version(Version::V8_5_0),
            new File(__DIR__ . '/../../../resources/wsdl/v8.5/TWINTMerchantService_v8.5.wsdl'),
        ];
        yield [
            Environment::TESTING(),
            new Version(Version::V8_6_0),
            new File(__DIR__ . '/../../../resources/wsdl/v8.6/TWINTMerchantService_v8.6.wsdl'),
        ];
    }

    /**
     * @return iterable<array{Environment::*, Environment}>
     */
    public static function getEnvironments(): iterable
    {
        yield [Environment::PRODUCTION, Environment::PRODUCTION()];
        yield [Environment::TESTING, Environment::TESTING()];
    }

    /**
     * @param Environment::* $environmentName
     */
    #[DataProvider('getEnvironmentNames')]
    public function testInstantiate(string $environmentName): void
    {
        $environment = new Environment($environmentName);

        self::assertSame($environmentName, (string) $environment);
    }

    public function testInvalidEnvironment(): void
    {
        $this->expectExceptionMessage('Expected ""TESTING"|"PRODUCTION"", got "string"');

        /** @phpstan-ignore-next-line */
        new Environment('INVALID');
    }

    /**
     * @param Environment::* $environmentName
     */
    #[DataProvider('getAppSchemes')]
    public function testEnvironmentSpecificAppSchemeUrls(string $environmentName, Url $appSchemeUrl): void
    {
        $environment = new Environment($environmentName);

        self::assertEquals($appSchemeUrl, $environment->appSchemeUrl());
    }

    #[DataProvider('getEnvironments')]
    public function testNamedConstructors(string $environmentName, Environment $environment): void
    {
        self::assertSame($environmentName, (string) $environment);
    }

    #[DataProvider('getSoapEndpoints')]
    public function testGetSoapEndpoints(Environment $environment, Version $version, Url $expectedUrl): void
    {
        self::assertEquals($expectedUrl, $environment->soapEndpoint($version));
    }

    #[DataProvider('getSoapTargetNamespaces')]
    public function testGetSoapTargetNamespaces(
        Environment $environment,
        Version $version,
        Url $expectedUrl
    ): void {
        self::assertEquals($expectedUrl, $environment->soapTargetNamespace($version));
    }

    #[DataProvider('getSoapWsdlPaths')]
    public function testSoapWsdlPaths(Environment $environment, Version $version, File $wsdl): void
    {
        self::assertEquals($wsdl, $environment->soapWsdlPath($version));
    }

    protected function createValue(): object
    {
        return Environment::TESTING();
    }

    protected static function getValueType(): string
    {
        return Environment::class;
    }
}
