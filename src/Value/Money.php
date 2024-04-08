<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use function Psl\Type\instance_of;
use function Psl\Type\union;

/**
 * @template-implements Enum<self::*>
 * @template-implements Comparable<self>
 * @template-implements Equality<self>
 */
final class Money implements Enum, Comparable, Equality
{
    /** @use ComparableToEquality<self> */
    use ComparableToEquality;

    public const EUR = 'EUR';

    public const CHF = 'CHF';

    public function __construct(
        private readonly string $currency,
        private readonly float $amount,
    ) {
        union(...array_map('Psl\Type\literal_scalar', self::all()))->assert($currency);
    }

    public static function EUR(float $amount): self
    {
        return new self(self::EUR, $amount);
    }

    public static function CHF(float $amount): self
    {
        return new self(self::CHF, $amount);
    }

    public static function all(): array
    {
        return [self::EUR, self::CHF];
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
