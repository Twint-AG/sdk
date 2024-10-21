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
final class InstallSource implements Value, Enum
{
    /**
     * @use ComparableToEquality<self>
     */
    use ComparableToEquality;

    public const DIRECT = 'D';

    public const STORE = 'S';

    /**
     * @param self::* $source
     */
    public function __construct(
        private readonly string $source
    ) {
        Type::maybeUnionOfLiterals(...self::all())->assert($source);
    }

    public static function DIRECT(): self
    {
        return new self(self::DIRECT);
    }

    public static function STORE(): self
    {
        return new self(self::STORE);
    }

    #[Override]
    public static function all(): array
    {
        return [self::DIRECT, self::STORE];
    }

    #[Override]
    public function __toString(): string
    {
        return $this->source;
    }

    #[Override]
    public function compare($other): int
    {
        instance_of(self::class)->assert($other);

        return $this->source <=> $other->source;
    }

    /**
     * @return self::*
     */
    #[Override]
    public function jsonSerialize(): string
    {
        return $this->source;
    }
}
