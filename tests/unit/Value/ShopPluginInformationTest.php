<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Value;

use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use Twint\Sdk\Value\InstallSource;
use Twint\Sdk\Value\PlatformVersion;
use Twint\Sdk\Value\PluginVersion;
use Twint\Sdk\Value\ShopPlatform;
use Twint\Sdk\Value\ShopPluginInformation;
use Twint\Sdk\Value\StoreUuid;

/**
 * @extends ValueTest<ShopPluginInformation>
 * @internal
 */
#[CoversClass(ShopPluginInformation::class)]
final class ShopPluginInformationTest extends ValueTest
{
    private const STORE_UUID = '0861d623-2445-4e4e-ba8e-84425b7136ff';

    /**
     * @return iterable<array{ShopPluginInformation, string}>
     */
    public static function getExamples(): iterable
    {
        yield [
            new ShopPluginInformation(
                StoreUuid::fromString(self::STORE_UUID),
                ShopPlatform::MAGENTO(),
                new PlatformVersion('2.4.7'),
                new PluginVersion('1.1.1-alpha2'),
                InstallSource::DIRECT()
            ),
            'mg|2.4.7|1.1.1-alpha2|D|f9fbdb7f',
        ];

        yield [
            new ShopPluginInformation(
                StoreUuid::fromString(self::STORE_UUID),
                ShopPlatform::SHOPWARE(),
                new PlatformVersion('6.4.17.0'),
                new PluginVersion('10.9.3.0-alpha5'),
                InstallSource::STORE()
            ),
            'sw|6.4.17.0|10.9.3.0-alpha5|S|b62de8a7',
        ];
    }

    public function testLengthIsBelow50BytesEvenForExtremelyLongVersions(): void
    {
        $info = new ShopPluginInformation(
            StoreUuid::fromString(self::STORE_UUID),
            ShopPlatform::MAGENTO(),
            new PlatformVersion(str_repeat('a', 50)),
            new PluginVersion(str_repeat('b', 50)),
            InstallSource::DIRECT()
        );

        self::assertLessThanOrEqual(50, strlen((string) $info));
    }

    public function testReturnsSelfForCashRegisterId(): void
    {
        $shopPluginInformation = new ShopPluginInformation(
            StoreUuid::fromString(self::STORE_UUID),
            ShopPlatform::MAGENTO(),
            new PlatformVersion('2.4.7'),
            new PluginVersion('1.1.1-alpha2'),
            InstallSource::DIRECT()
        );

        self::assertSame($shopPluginInformation, $shopPluginInformation->cashRegisterId());
    }

    public function testReturnsStoreUuidForStoreUuid(): void
    {
        $shopPluginInformation = new ShopPluginInformation(
            StoreUuid::fromString(self::STORE_UUID),
            ShopPlatform::MAGENTO(),
            new PlatformVersion('2.4.7'),
            new PluginVersion('1.1.1-alpha2'),
            InstallSource::DIRECT()
        );

        self::assertObjectEquals(StoreUuid::fromString(self::STORE_UUID), $shopPluginInformation->storeUuid());
    }

    #[DataProvider('getExamples')]
    public function testExamples(ShopPluginInformation $shopPluginInformation, string $expected): void
    {
        self::assertSame($expected, (string) $shopPluginInformation);
    }

    #[Override]
    protected function createValue(): object
    {
        return new ShopPluginInformation(
            StoreUuid::fromString(self::STORE_UUID),
            ShopPlatform::MAGENTO(),
            new PlatformVersion('2.4.7'),
            new PluginVersion('1.1.1-alpha2'),
            InstallSource::DIRECT()
        );
    }

    #[Override]
    protected static function getValueType(): string
    {
        return ShopPluginInformation::class;
    }
}
