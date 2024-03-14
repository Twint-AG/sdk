<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

class CustomerInformationType
{
    /**
     * @var array<int<0,max>, \Twint\Sdk\Generated\Type\LoyaltyType>
     */
    protected array $Loyalty;

    /**
     * @var array<int<0,max>, \Twint\Sdk\Generated\Type\CouponType>
     */
    protected array $Coupon;

    /**
     * Base type: restriction of xs:string Pattern: [A-Fa-f0-9]{32}|(\{|\()?[A-Fa-f0-9]{8}-([A-Fa-f0-9]{4}-){3}[A-Fa-f0-9]{12}(\}|\))? This type is used by other XML schema attributes or elements that will
     *  hold a universal unique identifier (UUID), commonly known as either a globally unique identifier (GUID) or UUID. The regular expression defined limits the contents of an attribute to either a
     *  single 32-digit hexadecimal string or a 32-digit hex string patterned as [8]-[4]-[4]-[4]-[12] digits.
     */
    protected ?string $CustomerRelationUuid;

    /**
     * @var array<int<0,max>, \Twint\Sdk\Generated\Type\KeyValueType>
     */
    protected array $Addendum;

    /**
     * @return array<int<0,max>, \Twint\Sdk\Generated\Type\LoyaltyType>
     */
    public function getLoyalty(): array
    {
        return $this->Loyalty;
    }

    /**
     * @param array<int<0,max>, \Twint\Sdk\Generated\Type\LoyaltyType> $Loyalty
     */
    public function withLoyalty(array $Loyalty): static
    {
        $new = clone $this;
        $new->Loyalty = $Loyalty;

        return $new;
    }

    /**
     * @return array<int<0,max>, \Twint\Sdk\Generated\Type\CouponType>
     */
    public function getCoupon(): array
    {
        return $this->Coupon;
    }

    /**
     * @param array<int<0,max>, \Twint\Sdk\Generated\Type\CouponType> $Coupon
     */
    public function withCoupon(array $Coupon): static
    {
        $new = clone $this;
        $new->Coupon = $Coupon;

        return $new;
    }

    public function getCustomerRelationUuid(): ?string
    {
        return $this->CustomerRelationUuid;
    }

    public function withCustomerRelationUuid(?string $CustomerRelationUuid): static
    {
        $new = clone $this;
        $new->CustomerRelationUuid = $CustomerRelationUuid;

        return $new;
    }

    /**
     * @return array<int<0,max>, \Twint\Sdk\Generated\Type\KeyValueType>
     */
    public function getAddendum(): array
    {
        return $this->Addendum;
    }

    /**
     * @param array<int<0,max>, \Twint\Sdk\Generated\Type\KeyValueType> $Addendum
     */
    public function withAddendum(array $Addendum): static
    {
        $new = clone $this;
        $new->Addendum = $Addendum;

        return $new;
    }
}
