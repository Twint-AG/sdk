<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

class CurrencyAmountType
{
    protected float $Amount;

    protected string $Currency;

    public function getAmount(): float
    {
        return $this->Amount;
    }

    public function withAmount(float $Amount): static
    {
        $new = clone $this;
        $new->Amount = $Amount;

        return $new;
    }

    public function getCurrency(): string
    {
        return $this->Currency;
    }

    public function withCurrency(string $Currency): static
    {
        $new = clone $this;
        $new->Currency = $Currency;

        return $new;
    }
}
