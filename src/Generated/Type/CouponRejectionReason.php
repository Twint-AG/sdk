<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

class CouponRejectionReason
{
    /**
     * @var 'ALREADY_REDEEMED' | 'ARTICLE_DELISTED' | 'CAMPAIGN_EXPIRED' | 'CAMPAIGN_CANCELED' | 'OTHER'
     */
    protected string $RejectionReason;

    protected ?string $Details = null;

    /**
     * @return 'ALREADY_REDEEMED' | 'ARTICLE_DELISTED' | 'CAMPAIGN_EXPIRED' | 'CAMPAIGN_CANCELED' | 'OTHER'
     */
    public function getRejectionReason(): string
    {
        return $this->RejectionReason;
    }

    /**
     * @param 'ALREADY_REDEEMED' | 'ARTICLE_DELISTED' | 'CAMPAIGN_EXPIRED' | 'CAMPAIGN_CANCELED' | 'OTHER' $RejectionReason
     */
    public function withRejectionReason(string $RejectionReason): static
    {
        $new = clone $this;
        $new->RejectionReason = $RejectionReason;

        return $new;
    }

    public function getDetails(): ?string
    {
        return $this->Details;
    }

    public function withDetails(?string $Details): static
    {
        $new = clone $this;
        $new->Details = $Details;

        return $new;
    }
}
