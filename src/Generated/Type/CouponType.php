<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use AllowDynamicProperties;

#[AllowDynamicProperties]
final class CouponType
{
    /**
     * @var string
     */
    private $CouponId;

    /**
     * @var CurrencyAmountType
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
     * @return CurrencyAmountType
     */
    public function getCouponValue()
    {
        return $this->CouponValue;
    }

    /**
     * @param CurrencyAmountType $CouponValue
     * @return CouponType
     */
    public function withCouponValue($CouponValue)
    {
        $new = clone $this;
        $new->CouponValue = $CouponValue;

        return $new;
    }
}
