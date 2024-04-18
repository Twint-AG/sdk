<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Integration;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use Twint\Sdk\Capability\DeviceHandling;
use Twint\Sdk\Client;
use Twint\Sdk\Factory\DefaultHttpClientFactory;
use Twint\Sdk\Value\DetectedDevice;

/**
 * @template-extends IntegrationTest<DeviceHandling>
 * @internal
 */
#[CoversClass(Client::class)]
#[CoversClass(DefaultHttpClientFactory::class)]
final class DeviceHandlingTest extends IntegrationTest
{
    /**
     * @return iterable<array{string, DetectedDevice::*}>
     */
    public static function getUserAgents(): iterable
    {
        yield [
            'Mozilla/5.0 (Linux; Android 11; SM-T227U Build/RP1A.200720.012; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/87.0.4280.141 Safari/537.36',
            DetectedDevice::ANDROID,
        ];
        yield [
            'Mozilla/5.0 (Linux; Android 10; SM-610N Build/QP1A.190711.020; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/80.0.3987.119 Mobile Safari/537.36',
            DetectedDevice::ANDROID,
        ];
        yield [
            'Mozilla/5.0 (Linux; Android 9; KFTRWI) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.88 Safari/537.36',
            DetectedDevice::ANDROID,
        ];
        yield [
            'Mozilla/5.0 (Linux; Android 8.1.0; Lenovo TB-X104X Build/OPM1.171019.026; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/80.0.3987.162 Safari/537.36',
            DetectedDevice::ANDROID,
        ];
        yield [
            'Mozilla/5.0 (Linux; Android 5.0.2; SAMSUNG SM-T550 Build/LRX22G) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/3.3 Chrome/38.0.2125.102 Safari/537.36',
            DetectedDevice::ANDROID,
        ];
        yield [
            'Mozilla/5.0 (Linux; Android 10; WGR-W19 Build/HUAWEIWGR-W19; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/83.0.4103.106 Safari/537.36',
            DetectedDevice::ANDROID,
        ];
        yield [
            'Mozilla/5.0 (Linux; Android 10; ATAB1021E) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.88 Safari/537.36',
            DetectedDevice::ANDROID,
        ];

        yield [
            'Mozilla/5.0 (iPhone; CPU iPhone OS 12_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) FxiOS/13.2b11866 Mobile/16A366 Safari/605.1.15',
            DetectedDevice::IOS,
        ];
        yield [
            'Mozilla/5.0 (iPhone13,3; U; CPU iPhone OS 14_0 like Mac OS X) AppleWebKit/602.1.50 (KHTML, like Gecko) Version/10.0 Mobile/15E148 Safari/602.1',
            DetectedDevice::IOS,
        ];
        yield [
            'Mozilla/5.0 (iPhone12,8; U; CPU iPhone OS 13_0 like Mac OS X) AppleWebKit/602.1.50 (KHTML, like Gecko) Version/10.0 Mobile/14A403 Safari/602.1',
            DetectedDevice::IOS,
        ];
        yield [
            'Mozilla/5.0 (iPhone; CPU iPhone OS 14_7_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.2 Mobile/15E148 Safari/604.1',
            DetectedDevice::IOS,
        ];
        yield [
            'Mozilla/5.0 (iPhone; CPU iPhone OS 14_7_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.2 Mobile/15E148 Safari/604.1',
            DetectedDevice::IOS,
        ];
        yield [
            'Mozilla/5.0 (iPhone; CPU iPhone OS 14_7_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.2 Mobile/15E148 Safari/604.1',
            DetectedDevice::IOS,
        ];
        yield [
            'Mozilla/5.0 (iPhone; CPU iPhone OS 14_2 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0.1 Mobile/15E148 Safari/604.1',
            DetectedDevice::IOS,
        ];
        yield [
            'Mozilla/5.0 (iPhone; CPU iPhone OS 14_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/92.0.4515.90 Mobile/15E148 Safari/604.1',
            DetectedDevice::IOS,
        ];
        yield [
            'Mozilla/5.0 (iPhone; CPU iPhone OS 12_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) FxiOS/13.2b11866 Mobile/16A366 Safari/605.1.15',
            DetectedDevice::IOS,
        ];
        yield [
            'Mozilla/5.0 (iPhone; CPU iPhone OS 14_7_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) FxiOS/36.0  Mobile/15E148 Safari/605.1.15',
            DetectedDevice::IOS,
        ];
        yield [
            'Mozilla/5.0 (iPhone; CPU iPhone OS 14_7_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) FxiOS/36.0  Mobile/15E148 Safari/605.1.15',
            DetectedDevice::IOS,
        ];
        yield [
            'Mozilla/5.0 (iPod; CPU iPhone OS 15_4_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) GSA/209.0.442442103 Mobile/19E258 Safari/604.1	',
            DetectedDevice::IOS,
        ];
        yield [
            'Mozilla/5.0 (iPad; CPU OS 17_3_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148 YJApp-IOS jp.co.yahoo.YWeatherApp/8.7.2',
            DetectedDevice::IOS,
        ];
        yield [
            'Mozilla/5.0 (iPad; CPU OS 17_4 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.3.1 Mobile/15E148 Safari/604.1',
            DetectedDevice::IOS,
        ];
        yield [
            'Mozilla/5.0 (iPod touch; CPU iPhone 17_4 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.3.1 Mobile/15E148 Safari/604.1',
            DetectedDevice::IOS,
        ];

        yield 'Apple Watch' => [
            'Mozilla/5.0 (Apple Watch5,9; CPU Apple Watch WatchOS like Mac OS X; WatchApp',
            DetectedDevice::UNKNOWN,
        ];
        yield 'Google Bot' => [
            'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; Googlebot/2.1; +http://www.google.com/bot.html) Chrome/92.0.4515.119 Safari/537.36',
            DetectedDevice::UNKNOWN,
        ];
        yield 'Nintendo Switch' => [
            'Mozilla/5.0 (Nintendo Switch; WifiWebAuthApplet) AppleWebKit/601.6 (KHTML, like Gecko) NF/4.0.0.5.10 NintendoBrowser/5.1.0.13343',
            DetectedDevice::UNKNOWN,
        ];
        yield 'Apple TV' => [
            'Mozilla/5.0 (AppleTV11,1; CPU OS 11.1 like Mac OS X; en-US)',
            DetectedDevice::UNKNOWN,
        ];
        yield 'macos' => [
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15',
            DetectedDevice::UNKNOWN,
        ];
    }

    #[DataProvider('getUserAgents')]
    public function testDetectDevice(string $userAgent, int $expectedType): void
    {
        $detectedDevice = $this->client->detectDevice($userAgent);

        self::assertSame($userAgent, $detectedDevice->userAgent());
        self::assertSame($expectedType, $detectedDevice->deviceType());
    }

    public function testGetIosAppSchemes(): void
    {
        $schemes = $this->client->getIosAppSchemes();

        self::assertGreaterThan(10, count($schemes));

        foreach ($schemes as $scheme) {
            self::assertStringStartsWith('twint-issuer', $scheme->scheme());
            self::assertNotEmpty($scheme->displayName());
        }
    }
}
