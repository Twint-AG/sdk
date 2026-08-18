<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use Override;
use Stringable;
use function Psl\invariant;
use function Psl\Type\instance_of;

/**
 * @template-implements Value<self>
 */
final class Money implements Stringable, Value
{
    /** @use ComparableToEquality<self> */
    use ComparableToEquality;

    public function __construct(
        private readonly Currency $currency,
        private readonly float $amount,
    ) {
    }

    public static function CHF(float $amount): self
    {
        return new self(Currency::CHF, $amount);
    }

    /**
     * @internal
     * @codeCoverageIgnore
     */
    public static function XXX(float $amount): self
    {
        return new self(Currency::XXX, $amount);
    }

    #[Override]
    public function __toString(): string
    {
        return sprintf('%s %s', number_format($this->amount, 2, '.', ''), $this->currency->value);
    }

    public function amount(): float
    {
        return $this->amount;
    }

    public function currency(): Currency
    {
        return $this->currency;
    }

    public function add(self $other): self
    {
        $this->checkCurrenciesMustMatch($other);

        return new self($this->currency, $this->amount + $other->amount);
    }

    public function subtract(self $other): self
    {
        $this->checkCurrenciesMustMatch($other);

        return new self($this->currency, $this->amount - $other->amount);
    }

    #[Override]
    public function compare($other): int
    {
        instance_of(self::class)->assert($other);

        if ($this->currency !== $other->currency) {
            return $this->currency->value <=> $other->currency->value;
        }

        return $this->amount <=> $other->amount;
    }

    /**
     * @return array{currency: Currency, amount: float}
     */
    #[Override]
    public function jsonSerialize(): array
    {
        return [
            'currency' => $this->currency,
            'amount' => $this->amount,
        ];
    }

    private function checkCurrenciesMustMatch(self $other): void
    {
        invariant(
            $this->currency === $other->currency,
            'Currencies must match. Expected "%s", got "%s"',
            $this->currency->value,
            $other->currency->value
        );
    }
}
