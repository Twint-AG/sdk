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

    /**
     * @param CouponType $ProcessedCoupon
     * @return CouponListType
     */
    public function withProcessedCoupon($ProcessedCoupon)
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

    /**
     * @param RejectedCouponType $RejectedCoupon
     * @return CouponListType
     */
    public function withRejectedCoupon($RejectedCoupon)
    {
        $new = clone $this;
        $new->RejectedCoupon = $RejectedCoupon;

        return $new;
    }
}
