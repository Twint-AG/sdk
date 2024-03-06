<?php

namespace Twint\Sdk\Generated\Type;

class RejectedCouponType
{
    /**
     * @var string
     */
    private $CouponId;

    /**
     * @var \Twint\Sdk\Generated\Type\CouponRejectionReason
     */
    private $RejectionReason;

    /**
     * @return string
     */
    public function getCouponId()
    {
        return $this->CouponId;
    }

    /**
     * @param string $CouponId
     * @return RejectedCouponType
     */
    public function withCouponId($CouponId)
    {
        $new = clone $this;
        $new->CouponId = $CouponId;

        return $new;
    }

    /**
     * @return \Twint\Sdk\Generated\Type\CouponRejectionReason
     */
    public function getRejectionReason()
    {
        return $this->RejectionReason;
    }

    /**
     * @param \Twint\Sdk\Generated\Type\CouponRejectionReason $RejectionReason
     * @return RejectedCouponType
     */
    public function withRejectionReason($RejectionReason)
    {
        $new = clone $this;
        $new->RejectionReason = $RejectionReason;

        return $new;
    }
}

