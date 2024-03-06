<?php

namespace Twint\Sdk\Generated\Type;

class PaymentAmountType
{
    /**
     * @var string
     */
    private $PaymentMethod;

    /**
     * @var \Twint\Sdk\Generated\Type\CurrencyAmountType
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
     * @return \Twint\Sdk\Generated\Type\CurrencyAmountType
     */
    public function getAmount()
    {
        return $this->Amount;
    }

    /**
     * @param \Twint\Sdk\Generated\Type\CurrencyAmountType $Amount
     * @return PaymentAmountType
     */
    public function withAmount($Amount)
    {
        $new = clone $this;
        $new->Amount = $Amount;

        return $new;
    }
}

