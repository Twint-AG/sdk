<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

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

    public function withPaymentMethod(string $PaymentMethod): self
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

    public function withAmount(CurrencyAmountType $Amount): self
    {
        $new = clone $this;
        $new->Amount = $Amount;

        return $new;
    }
}
