<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use function Psl\Type\literal_scalar;
use function Psl\Type\union;

final class DetectedDevice
{
    public const UNKNOWN = 0;

    public const IOS = 1;

    public const ANDROID = 2;

    public function __construct(
        private readonly string $userAgent,
        private readonly int $deviceType
    ) {
        union(
            literal_scalar(self::UNKNOWN),
            literal_scalar(self::IOS),
            literal_scalar(self::ANDROID)
        )->assert($deviceType);
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
