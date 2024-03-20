<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

final class CouponListType
{
    /**
     * @var CouponType
     */
    private $ProcessedCoupon;

    /**
     * @var RejectedCouponType
     */
    private $RejectedCoupon;

    /**
     * @return CouponType
     */
    public function getProcessedCoupon()
    {
        return $this->ProcessedCoupon;
    }

    public function withProcessedCoupon(CouponType $ProcessedCoupon): self
    {
        $new = clone $this;
        $new->ProcessedCoupon = $ProcessedCoupon;

        return $new;
    }

    /**
     * @return RejectedCouponType
     */
    public function getRejectedCoupon()
    {
        return $this->RejectedCoupon;
    }

    public function withRejectedCoupon(RejectedCouponType $RejectedCoupon): self
    {
        $new = clone $this;
        $new->RejectedCoupon = $RejectedCoupon;

        return $new;
    }
}
