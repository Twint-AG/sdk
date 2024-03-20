<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

final class CurrencyAmountType
{
    /**
     * @var float
     */
    private $Amount;

    /**
     * @var string
     */
    private $Currency;

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->Amount;
    }

    public function withAmount(float $Amount): self
    {
        $new = clone $this;
        $new->Amount = $Amount;

        return $new;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->Currency;
    }

    public function withCurrency(string $Currency): self
    {
        $new = clone $this;
        $new->Currency = $Currency;

        return $new;
    }
}
