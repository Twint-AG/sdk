<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use Phpro\SoapClient\Type\RequestInterface;

final class CancelCheckInRequestType implements RequestInterface
{
    /**
     * @var MerchantInformationType
     */
    private $MerchantInformation;

    /**
     * @var string
     */
    private $Reason;

    /**
     * @var string
     */
    private $CustomerRelationUuid;

    /**
     * @var string
     */
    private $PairingUuid;

    /**
     * @var CouponListType
     */
    private $Coupons;

    /**
     * Constructor
     *
     * @param MerchantInformationType $MerchantInformation
     * @param string $Reason
     * @param string $CustomerRelationUuid
     * @param string $PairingUuid
     * @param CouponListType $Coupons
     */
    public function __construct($MerchantInformation, $Reason, $CustomerRelationUuid, $PairingUuid, $Coupons)
    {
        $this->MerchantInformation = $MerchantInformation;
        $this->Reason = $Reason;
        $this->CustomerRelationUuid = $CustomerRelationUuid;
        $this->PairingUuid = $PairingUuid;
        $this->Coupons = $Coupons;
    }

    /**
     * @return MerchantInformationType
     */
    public function getMerchantInformation()
    {
        return $this->MerchantInformation;
    }

    public function withMerchantInformation(MerchantInformationType $MerchantInformation): self
    {
        $new = clone $this;
        $new->MerchantInformation = $MerchantInformation;

        return $new;
    }

    /**
     * @return string
     */
    public function getReason()
    {
        return $this->Reason;
    }

    public function withReason(string $Reason): self
    {
        $new = clone $this;
        $new->Reason = $Reason;

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
     * @return string
     */
    public function getPairingUuid()
    {
        return $this->PairingUuid;
    }

    public function withPairingUuid(string $PairingUuid): self
    {
        $new = clone $this;
        $new->PairingUuid = $PairingUuid;

        return $new;
    }

    /**
     * @return CouponListType
     */
    public function getCoupons()
    {
        return $this->Coupons;
    }

    public function withCoupons(CouponListType $Coupons): self
    {
        $new = clone $this;
        $new->Coupons = $Coupons;

        return $new;
    }
}
