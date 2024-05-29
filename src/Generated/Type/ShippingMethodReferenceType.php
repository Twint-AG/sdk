<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

class ShippingMethodReferenceType
{
    protected string $ShippingMethodId;

    protected string $ShippingMethodLabel;

    protected CurrencyAmountType $ShippingMethodAmount;

    public function getShippingMethodId(): string
    {
        return $this->ShippingMethodId;
    }

    public function withShippingMethodId(string $ShippingMethodId): static
    {
        $new = clone $this;
        $new->ShippingMethodId = $ShippingMethodId;

        return $new;
    }

    public function getShippingMethodLabel(): string
    {
        return $this->ShippingMethodLabel;
    }

    public function withShippingMethodLabel(string $ShippingMethodLabel): static
    {
        $new = clone $this;
        $new->ShippingMethodLabel = $ShippingMethodLabel;

        return $new;
    }

    public function getShippingMethodAmount(): CurrencyAmountType
    {
        return $this->ShippingMethodAmount;
    }

    public function withShippingMethodAmount(CurrencyAmountType $ShippingMethodAmount): static
    {
        $new = clone $this;
        $new->ShippingMethodAmount = $ShippingMethodAmount;

        return $new;
    }
}
