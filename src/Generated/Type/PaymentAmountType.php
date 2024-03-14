<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

class PaymentAmountType
{
    protected string $PaymentMethod;

    protected CurrencyAmountType $Amount;

    public function getPaymentMethod(): string
    {
        return $this->PaymentMethod;
    }

    public function withPaymentMethod(string $PaymentMethod): static
    {
        $new = clone $this;
        $new->PaymentMethod = $PaymentMethod;

        return $new;
    }

    public function getAmount(): CurrencyAmountType
    {
        return $this->Amount;
    }

    public function withAmount(CurrencyAmountType $Amount): static
    {
        $new = clone $this;
        $new->Amount = $Amount;

        return $new;
    }
}
