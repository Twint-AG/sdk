<?php

namespace Twint\Sdk\Generated\Type;

class CouponType
{
    /**
     * @var string
     */
    private $CouponId;

    /**
     * @var \Twint\Sdk\Generated\Type\CurrencyAmountType
     */
    private $CouponValue;

    /**
     * @return string
     */
    public function getCouponId()
    {
        return $this->CouponId;
    }

    /**
     * @param string $CouponId
     * @return CouponType
     */
    public function withCouponId($CouponId)
    {
        $new = clone $this;
        $new->CouponId = $CouponId;

        return $new;
    }

    /**
     * @return \Twint\Sdk\Generated\Type\CurrencyAmountType
     */
    public function getCouponValue()
    {
        return $this->CouponValue;
    }

    /**
     * @param \Twint\Sdk\Generated\Type\CurrencyAmountType $CouponValue
     * @return CouponType
     */
    public function withCouponValue($CouponValue)
    {
        $new = clone $this;
        $new->CouponValue = $CouponValue;

        return $new;
    }
}

