<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

final class RejectedCouponType
{
    /**
     * @var string
     */
    private $CouponId;

    /**
     * @var CouponRejectionReason
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
     * @return CouponRejectionReason
     */
    public function getRejectionReason()
    {
        return $this->RejectionReason;
    }

    /**
     * @param CouponRejectionReason $RejectionReason
     * @return RejectedCouponType
     */
    public function withRejectionReason($RejectionReason)
    {
        $new = clone $this;
        $new->RejectionReason = $RejectionReason;

        return $new;
    }
}
