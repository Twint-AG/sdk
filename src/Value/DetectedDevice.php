<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use Override;
use Twint\Sdk\Util\Comparison;
use Twint\Sdk\Util\Type;
use function Psl\Type\instance_of;

/**
 * @template-implements Enum<self::*>
 * @template-implements Comparable<self>
 * @template-implements Equality<self>
 */
final class DetectedDevice implements Enum, Comparable, Equality
{
    /**
     * @use ComparableToEquality<self>
     */
    use ComparableToEquality;

    public const UNKNOWN = 0;

    public const IOS = 1;

    public const ANDROID = 2;

    public function __construct(
        private readonly string $userAgent,
        private readonly int $deviceType
    ) {
        Type::maybeUnionOfLiterals(...self::all())->assert($this->deviceType);
    }

    public static function UNKNOWN(string $userAgent): self
    {
        return new self($userAgent, self::UNKNOWN);
    }

    public static function IOS(string $userAgent): self
    {
        return new self($userAgent, self::IOS);
    }

    public static function ANDROID(string $userAgent): self
    {
        return new self($userAgent, self::ANDROID);
    }

    #[Override]
    public static function all(): array
    {
        return [self::UNKNOWN, self::IOS, self::ANDROID];
    }

    #[Override]
    public function __toString(): string
    {
        return sprintf('%s (%d)', $this->userAgent, $this->deviceType);
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

    public function isUnknown(): bool
    {
        return $this->deviceType === self::UNKNOWN;
    }

    #[Override]
    public function compare($other): int
    {
        instance_of(self::class)->assert($other);

        return Comparison::comparePairs([
            [$this->deviceType, $other->deviceType],
            [$this->userAgent, $other->userAgent],
        ]);
    }
}
