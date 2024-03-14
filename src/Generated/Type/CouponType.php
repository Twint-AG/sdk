<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

class CouponType
{
    protected string $CouponId;

    protected ?CurrencyAmountType $CouponValue;

    public function getCouponId(): string
    {
        return $this->CouponId;
    }

    public function withCouponId(string $CouponId): static
    {
        $new = clone $this;
        $new->CouponId = $CouponId;

        return $new;
    }

    public function getCouponValue(): ?CurrencyAmountType
    {
        return $this->CouponValue;
    }

    public function withCouponValue(?CurrencyAmountType $CouponValue): static
    {
        $new = clone $this;
        $new->CouponValue = $CouponValue;

        return $new;
    }
}
