<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use Override;
use Twint\Sdk\Util\Type;
use function Psl\Type\instance_of;

/**
 * @template-implements Enum<self::*>
 * @template-implements Value<self>
 */
final class ShopPlatform implements Value, Enum
{
    /**
     * @use ComparableToEquality<self>
     */
    use ComparableToEquality;

    public const MAGENTO = 'mg';

    public const SHOPWARE = 'sw';

    public const WOOCOMMERCE = 'wc';

    public const OTHER = 'ot';

    /**
     * @param self::* $platform
     */
    public function __construct(
        private readonly string $platform
    ) {
        Type::maybeUnionOfLiterals(...self::all())->assert($platform);
    }

    public static function MAGENTO(): self
    {
        return new self(self::MAGENTO);
    }

    public static function SHOPWARE(): self
    {
        return new self(self::SHOPWARE);
    }

    public static function WOOCOMMERCE(): self
    {
        return new self(self::WOOCOMMERCE);
    }

    public static function OTHER(): self
    {
        return new self(self::OTHER);
    }

    #[Override]
    public static function all(): array
    {
        return [self::SHOPWARE, self::WOOCOMMERCE, self::MAGENTO, self::OTHER];
    }

    #[Override]
    public function __toString(): string
    {
        return $this->platform;
    }

    #[Override]
    public function compare($other): int
    {
        instance_of(self::class)->assert($other);

        return $this->platform <=> $other->platform;
    }

    #[Override]
    public function jsonSerialize(): string
    {
        return $this->platform;
    }
}
