<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

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

    public function withCouponId(string $CouponId): self
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

    public function withCouponValue(CurrencyAmountType $CouponValue): self
    {
        $new = clone $this;
        $new->CouponValue = $CouponValue;

        return $new;
    }
}
