<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

final class CustomerInformationType
{
    /**
     * @var LoyaltyType
     */
    private $Loyalty;

    /**
     * @var CouponType
     */
    private $Coupon;

    /**
     * @var string
     */
    private $CustomerRelationUuid;

    /**
     * @var KeyValueType
     */
    private $Addendum;

    /**
     * @return LoyaltyType
     */
    public function getLoyalty()
    {
        return $this->Loyalty;
    }

    public function withLoyalty(LoyaltyType $Loyalty): self
    {
        $new = clone $this;
        $new->Loyalty = $Loyalty;

        return $new;
    }

    /**
     * @return CouponType
     */
    public function getCoupon()
    {
        return $this->Coupon;
    }

    public function withCoupon(CouponType $Coupon): self
    {
        $new = clone $this;
        $new->Coupon = $Coupon;

        return $new;
    }

    /**
     * @return string
     */
    public function getCustomerRelationUuid()
    {
        return $this->CustomerRelationUuid;
    }

    public function withCustomerRelationUuid(string $CustomerRelationUuid): self
    {
        $new = clone $this;
        $new->CustomerRelationUuid = $CustomerRelationUuid;

        return $new;
    }

    /**
     * @return KeyValueType
     */
    public function getAddendum()
    {
        return $this->Addendum;
    }

    public function withAddendum(KeyValueType $Addendum): self
    {
        $new = clone $this;
        $new->Addendum = $Addendum;

        return $new;
    }
}
