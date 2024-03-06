<?php

namespace Twint\Sdk\Generated\Type;

class CouponListType
{
    /**
     * @var \Twint\Sdk\Generated\Type\CouponType
     */
    private $ProcessedCoupon;

    /**
     * @var \Twint\Sdk\Generated\Type\RejectedCouponType
     */
    private $RejectedCoupon;

    /**
     * @return \Twint\Sdk\Generated\Type\CouponType
     */
    public function getProcessedCoupon()
    {
        return $this->ProcessedCoupon;
    }

    /**
     * @param \Twint\Sdk\Generated\Type\CouponType $ProcessedCoupon
     * @return CouponListType
     */
    public function withProcessedCoupon($ProcessedCoupon)
    {
        $new = clone $this;
        $new->ProcessedCoupon = $ProcessedCoupon;

        return $new;
    }

    /**
     * @return \Twint\Sdk\Generated\Type\RejectedCouponType
     */
    public function getRejectedCoupon()
    {
        return $this->RejectedCoupon;
    }

    /**
     * @param \Twint\Sdk\Generated\Type\RejectedCouponType $RejectedCoupon
     * @return CouponListType
     */
    public function withRejectedCoupon($RejectedCoupon)
    {
        $new = clone $this;
        $new->RejectedCoupon = $RejectedCoupon;

        return $new;
    }
}

