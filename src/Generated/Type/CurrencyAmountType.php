<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use AllowDynamicProperties;

#[AllowDynamicProperties]
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

    /**
     * @param float $Amount
     * @return CurrencyAmountType
     */
    public function withAmount($Amount)
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

    /**
     * @param string $Currency
     * @return CurrencyAmountType
     */
    public function withCurrency($Currency)
    {
        $new = clone $this;
        $new->Currency = $Currency;

        return $new;
    }
}
