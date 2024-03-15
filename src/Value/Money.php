<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use Twint\Sdk\Assertion;
use Twint\Sdk\Exception\AssertionFailed;

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

    /**
     * @throws AssertionFailed
     */
    public function __construct(
        private readonly string $currency,
        private readonly float $amount,
    ) {
        Assertion::choice($currency, self::all(), '"%s" is not a valid currency. Supported currencies: %s');
    }

    /**
     * @throws AssertionFailed
     */
    public static function EUR(float $amount): self
    {
        return new self(self::EUR, $amount);
    }

    /**
     * @throws AssertionFailed
     */
    public static function CHF(float $amount): self
    {
        return new self(self::CHF, $amount);
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

    public function all(): array
    {
        return [self::EUR, self::CHF];
    }

    /**
     * @throws AssertionFailed
     */
    public function compare($other): int
    {
        Assertion::isObject($other, self::class);

        if ($this->currency !== $other->currency) {
            return $this->currency <=> $other->currency;
        }

        return $this->amount <=> $other->amount;
    }
}
