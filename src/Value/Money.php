<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use PHPUnit\Framework\Attributes\CodeCoverageIgnore;
use Twint\Sdk\Util\Type;
use function Psl\Type\instance_of;

/**
 * @template-implements Enum<self::*>
 * @template-implements Comparable<self>
 * @template-implements Equality<self>
 */
final class Money implements Enum, Comparable, Equality
{
    /** @use ComparableToEquality<self> */
    use ComparableToEquality;

    public const CHF = 'CHF';

    /**
     * @internal
     */
    public const XXX = 'XXX';

    public function __construct(
        private readonly string $currency,
        private readonly float $amount,
    ) {
        Type::maybeUnionOfLiterals(...self::all())->assert($currency);
    }

    public static function CHF(float $amount): self
    {
        return new self(self::CHF, $amount);
    }

    /**
     * @internal
     */
    #[CodeCoverageIgnore]
    public static function XXX(float $amount): self
    {
        return new self(self::XXX, $amount);
    }

    public static function all(): array
    {
        return [self::CHF, self::XXX];
    }

    public function __toString(): string
    {
        return sprintf('%s %s', number_format($this->amount, 2, '.', ''), $this->currency);
    }

    public function amount(): float
    {
        return $this->amount;
    }

    public function currency(): string
    {
        return $this->currency;
    }

    public function compare($other): int
    {
        instance_of(self::class)->assert($other);

        if ($this->currency !== $other->currency) {
            return $this->currency <=> $other->currency;
        }

        return $this->amount <=> $other->amount;
    }
}
