<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Twint\Sdk\TwintEnvironment;
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
        $this->expectExceptionMessage('Invalid environment "INVALID" specified. Expected one of TESTING, PRODUCTION.');

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

        self::assertTrue($appSchemeUrl->equals($environment->appSchemeUrl()));
    }

    #[DataProvider('getEnvironments')]
    public function testNamedConstructors(string $environmentName, TwintEnvironment $environment): void
    {
        self::assertSame($environmentName, (string) $environment);
    }
}
