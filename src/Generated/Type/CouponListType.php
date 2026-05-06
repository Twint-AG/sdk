<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

class CouponListType
{
    /**
     * @var array<int<0, max>, CouponType>
     */
    protected array $ProcessedCoupon;

    /**
     * @var array<int<0, max>, RejectedCouponType>
     */
    protected array $RejectedCoupon;

    /**
     * @return array<int<0, max>, CouponType>
     */
    public function getProcessedCoupon(): array
    {
        return $this->ProcessedCoupon;
    }

    /**
     * @param array<int<0, max>, CouponType> $ProcessedCoupon
     */
    public function withProcessedCoupon(array $ProcessedCoupon): static
    {
        $new = clone $this;
        $new->ProcessedCoupon = $ProcessedCoupon;

        return $new;
    }

    /**
     * @return array<int<0, max>, RejectedCouponType>
     */
    public function getRejectedCoupon(): array
    {
        return $this->RejectedCoupon;
    }

    /**
     * @param array<int<0, max>, RejectedCouponType> $RejectedCoupon
     */
    public function withRejectedCoupon(array $RejectedCoupon): static
    {
        $new = clone $this;
        $new->RejectedCoupon = $RejectedCoupon;

        return $new;
    }
}
