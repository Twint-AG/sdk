<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use AllowDynamicProperties;

#[AllowDynamicProperties]
final class PaymentAmountType
{
    /**
     * @var string
     */
    private $PaymentMethod;

    /**
     * @var CurrencyAmountType
     */
    private $Amount;

    /**
     * @return string
     */
    public function getPaymentMethod()
    {
        return $this->PaymentMethod;
    }

    /**
     * @param string $PaymentMethod
     * @return PaymentAmountType
     */
    public function withPaymentMethod($PaymentMethod)
    {
        $new = clone $this;
        $new->PaymentMethod = $PaymentMethod;

        return $new;
    }

    /**
     * @return CurrencyAmountType
     */
    public function getAmount()
    {
        return $this->Amount;
    }

    /**
     * @param CurrencyAmountType $Amount
     * @return PaymentAmountType
     */
    public function withAmount($Amount)
    {
        $new = clone $this;
        $new->Amount = $Amount;

        return $new;
    }
}
