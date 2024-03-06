<?php

namespace Twint\Sdk\Generated\Type;

class CouponRejectionReason
{
    /**
     * @var string
     */
    private $RejectionReason;

    /**
     * @var string
     */
    private $Details;

    /**
     * @return string
     */
    public function getRejectionReason()
    {
        return $this->RejectionReason;
    }

    /**
     * @param string $RejectionReason
     * @return CouponRejectionReason
     */
    public function withRejectionReason($RejectionReason)
    {
        $new = clone $this;
        $new->RejectionReason = $RejectionReason;

        return $new;
    }

    /**
     * @return string
     */
    public function getDetails()
    {
        return $this->Details;
    }

    /**
     * @param string $Details
     * @return CouponRejectionReason
     */
    public function withDetails($Details)
    {
        $new = clone $this;
        $new->Details = $Details;

        return $new;
    }
}

