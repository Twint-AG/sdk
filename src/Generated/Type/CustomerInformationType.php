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

    /**
     * @param LoyaltyType $Loyalty
     * @return CustomerInformationType
     */
    public function withLoyalty($Loyalty)
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

    /**
     * @param CouponType $Coupon
     * @return CustomerInformationType
     */
    public function withCoupon($Coupon)
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

    /**
     * @param string $CustomerRelationUuid
     * @return CustomerInformationType
     */
    public function withCustomerRelationUuid($CustomerRelationUuid)
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

    /**
     * @param KeyValueType $Addendum
     * @return CustomerInformationType
     */
    public function withAddendum($Addendum)
    {
        $new = clone $this;
        $new->Addendum = $Addendum;

        return $new;
    }
}
