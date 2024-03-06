<?php

namespace Twint\Sdk\Generated\Type;

class ShippingMethodReferenceType
{
    /**
     * @var string
     */
    private $ShippingMethodId;

    /**
     * @var string
     */
    private $ShippingMethodLabel;

    /**
     * @var \Twint\Sdk\Generated\Type\CurrencyAmountType
     */
    private $ShippingMethodAmount;

    /**
     * @return string
     */
    public function getShippingMethodId()
    {
        return $this->ShippingMethodId;
    }

    /**
     * @param string $ShippingMethodId
     * @return ShippingMethodReferenceType
     */
    public function withShippingMethodId($ShippingMethodId)
    {
        $new = clone $this;
        $new->ShippingMethodId = $ShippingMethodId;

        return $new;
    }

    /**
     * @return string
     */
    public function getShippingMethodLabel()
    {
        return $this->ShippingMethodLabel;
    }

    /**
     * @param string $ShippingMethodLabel
     * @return ShippingMethodReferenceType
     */
    public function withShippingMethodLabel($ShippingMethodLabel)
    {
        $new = clone $this;
        $new->ShippingMethodLabel = $ShippingMethodLabel;

        return $new;
    }

    /**
     * @return \Twint\Sdk\Generated\Type\CurrencyAmountType
     */
    public function getShippingMethodAmount()
    {
        return $this->ShippingMethodAmount;
    }

    /**
     * @param \Twint\Sdk\Generated\Type\CurrencyAmountType $ShippingMethodAmount
     * @return ShippingMethodReferenceType
     */
    public function withShippingMethodAmount($ShippingMethodAmount)
    {
        $new = clone $this;
        $new->ShippingMethodAmount = $ShippingMethodAmount;

        return $new;
    }
}

