<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use Override;
use PHPUnit\Framework\Attributes\CodeCoverageIgnore;
use Twint\Sdk\Util\Type;
use function Psl\invariant;
use function Psl\Type\instance_of;

/**
 * @template-implements Enum<self::*>
 * @template-implements Value<self>
 */
final class Money implements Value, Enum
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

    #[Override]
    public static function all(): array
    {
        return [self::CHF, self::XXX];
    }

    #[Override]
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
            return $this->currency <=> $other->currency;
        }

        return $this->amount <=> $other->amount;
    }

    /**
     * @return array{currency: string, amount: float}
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
            $this->currency,
            $other->currency
        );
    }
}
