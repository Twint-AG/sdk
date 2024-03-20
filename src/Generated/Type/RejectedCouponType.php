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

    public function withCouponId(string $CouponId): self
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

    public function withRejectionReason(CouponRejectionReason $RejectionReason): self
    {
        $new = clone $this;
        $new->RejectionReason = $RejectionReason;

        return $new;
    }
}
