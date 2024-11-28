<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

class ShippingMethodReferenceType
{
    /**
     * A type for the identifier of a shipping method.
     *  Base type: restriction of xs:string. Pattern: [A-Za-z0-9\-_+]{1,128}
     */
    protected string $ShippingMethodId;

    /**
     * This type is based on xs:string and is used for restricted labels,
     *  it allows basic latin, mathematical and currency symbols with
     *  a minimum length of 1 and a maximum length of 256 characters.
     *
     *  The label must match the pattern: [\p{IsBasicLatin}\p{P}\p{Sm}\p{Sc}]{1,256}
     */
    protected string $ShippingMethodLabel;

    /**
     * This type is based on xs:string and is used for restricted labels,
     *  it allows basic latin, mathematical and currency symbols with
     *  a minimum length of 1 and a maximum length of 256 characters.
     *
     *  The label must match the pattern: [\p{IsBasicLatin}\p{P}\p{Sm}\p{Sc}]{1,256}
     */
    protected ?string $ShippingMethodDescription = null;

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

    public function getShippingMethodDescription(): ?string
    {
        return $this->ShippingMethodDescription;
    }

    public function withShippingMethodDescription(?string $ShippingMethodDescription): static
    {
        $new = clone $this;
        $new->ShippingMethodDescription = $ShippingMethodDescription;

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
