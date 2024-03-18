<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use Twint\Sdk\Assertion;
use Twint\Sdk\Exception\AssertionFailed;

final class DetectedDevice
{
    public const UNKNOWN = 0;

    public const IOS = 1;

    public const ANDROID = 2;

    /**
     * @throws AssertionFailed
     */
    public function __construct(
        private readonly string $userAgent,
        private readonly int $deviceType
    ) {
        Assertion::choice($deviceType, [self::UNKNOWN, self::IOS, self::ANDROID], 'Invalid device type');
    }

    public function userAgent(): string
    {
        return $this->userAgent;
    }

    public function deviceType(): int
    {
        return $this->deviceType;
    }

    public function isIos(): bool
    {
        return $this->deviceType === self::IOS;
    }

    public function isAndroid(): bool
    {
        return $this->deviceType === self::ANDROID;
    }

    public function isMobile(): bool
    {
        return $this->isIos() || $this->isAndroid();
    }
}
