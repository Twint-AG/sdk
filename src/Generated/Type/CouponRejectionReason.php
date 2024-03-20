<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

final class CouponRejectionReason
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

    public function withRejectionReason(string $RejectionReason): self
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

    public function withDetails(string $Details): self
    {
        $new = clone $this;
        $new->Details = $Details;

        return $new;
    }
}
