<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Value;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use Twint\Sdk\Value\DetectedDevice;

/**
 * @template-extends ValueTest<DetectedDevice>
 */
#[CoversClass(DetectedDevice::class)]
final class DetectedDeviceTest extends ValueTest
{
    private const UNKNOWN_USER_AGENT = 'Some Unknown UA';

    private const IPHONE_USER_AGENT = 'Some iPhone UA';

    private const ANDROID_USER_AGENT = 'Some Android UA';

    /**
     * @return iterable<array{DetectedDevice, int, bool, bool, bool, bool}>
     */
    public static function getClassifications(): iterable
    {
        return [
            [DetectedDevice::UNKNOWN(self::UNKNOWN_USER_AGENT), DetectedDevice::UNKNOWN, false, false, false, true],
            [DetectedDevice::IOS(self::IPHONE_USER_AGENT), DetectedDevice::IOS, true, true, false, false],
            [DetectedDevice::ANDROID(self::ANDROID_USER_AGENT), DetectedDevice::ANDROID, true, false, true, false],
        ];
    }

    protected function createValue(): object
    {
        return new DetectedDevice(self::IPHONE_USER_AGENT, DetectedDevice::IOS);
    }

    protected static function getValueType(): string
    {
        return DetectedDevice::class;
    }

    #[DataProvider('getClassifications')]
    public function testClassifications(
        DetectedDevice $detectedDevice,
        int $deviceType,
        bool $isMobile,
        bool $isIos,
        bool $isAndroid,
        bool $isUnknown
    ): void {
        self::assertSame($deviceType, $detectedDevice->deviceType());
        self::assertSame($isMobile, $detectedDevice->isMobile());
        self::assertSame($isIos, $detectedDevice->isIos());
        self::assertSame($isAndroid, $detectedDevice->isAndroid());
        self::assertSame($isUnknown, $detectedDevice->isUnknown());
    }

    public function testCreateAndroid(): void
    {
        $detectedDevice = DetectedDevice::ANDROID(self::ANDROID_USER_AGENT);

        self::assertSame(DetectedDevice::ANDROID, $detectedDevice->deviceType());
        self::assertSame(self::ANDROID_USER_AGENT, $detectedDevice->userAgent());
    }

    public function testCreateIos(): void
    {
        $detectedDevice = DetectedDevice::IOS(self::IPHONE_USER_AGENT);

        self::assertSame(DetectedDevice::IOS, $detectedDevice->deviceType());
        self::assertSame(self::IPHONE_USER_AGENT, $detectedDevice->userAgent());
    }

    public function testCreateUnknown(): void
    {
        $detectedDevice = DetectedDevice::UNKNOWN(self::UNKNOWN_USER_AGENT);

        self::assertSame(DetectedDevice::UNKNOWN, $detectedDevice->deviceType());
        self::assertSame(self::UNKNOWN_USER_AGENT, $detectedDevice->userAgent());
    }
}
