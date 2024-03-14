<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

class RejectedCouponType
{
    protected string $CouponId;

    protected CouponRejectionReason $RejectionReason;

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

    public function getRejectionReason(): CouponRejectionReason
    {
        return $this->RejectionReason;
    }

    public function withRejectionReason(CouponRejectionReason $RejectionReason): static
    {
        $new = clone $this;
        $new->RejectionReason = $RejectionReason;

        return $new;
    }
}
