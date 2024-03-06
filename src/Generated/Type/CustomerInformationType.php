<?php

namespace Twint\Sdk\Generated\Type;

class CustomerInformationType
{
    /**
     * @var \Twint\Sdk\Generated\Type\LoyaltyType
     */
    private $Loyalty;

    /**
     * @var \Twint\Sdk\Generated\Type\CouponType
     */
    private $Coupon;

    /**
     * @var string
     */
    private $CustomerRelationUuid;

    /**
     * @var \Twint\Sdk\Generated\Type\KeyValueType
     */
    private $Addendum;

    /**
     * @return \Twint\Sdk\Generated\Type\LoyaltyType
     */
    public function getLoyalty()
    {
        return $this->Loyalty;
    }

    /**
     * @param \Twint\Sdk\Generated\Type\LoyaltyType $Loyalty
     * @return CustomerInformationType
     */
    public function withLoyalty($Loyalty)
    {
        $new = clone $this;
        $new->Loyalty = $Loyalty;

        return $new;
    }

    /**
     * @return \Twint\Sdk\Generated\Type\CouponType
     */
    public function getCoupon()
    {
        return $this->Coupon;
    }

    /**
     * @param \Twint\Sdk\Generated\Type\CouponType $Coupon
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
     * @return \Twint\Sdk\Generated\Type\KeyValueType
     */
    public function getAddendum()
    {
        return $this->Addendum;
    }

    /**
     * @param \Twint\Sdk\Generated\Type\KeyValueType $Addendum
     * @return CustomerInformationType
     */
    public function withAddendum($Addendum)
    {
        $new = clone $this;
        $new->Addendum = $Addendum;

        return $new;
    }
}

