<?php

namespace Twint\Sdk\Generated\Type;

use Phpro\SoapClient\Type\RequestInterface;

class CancelCheckInRequestType implements RequestInterface
{
    /**
     * @var \Twint\Sdk\Generated\Type\MerchantInformationType
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
     * @var \Twint\Sdk\Generated\Type\CouponListType
     */
    private $Coupons;

    /**
     * Constructor
     *
     * @var \Twint\Sdk\Generated\Type\MerchantInformationType $MerchantInformation
     * @var string $Reason
     * @var string $CustomerRelationUuid
     * @var string $PairingUuid
     * @var \Twint\Sdk\Generated\Type\CouponListType $Coupons
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
     * @return \Twint\Sdk\Generated\Type\MerchantInformationType
     */
    public function getMerchantInformation()
    {
        return $this->MerchantInformation;
    }

    /**
     * @param \Twint\Sdk\Generated\Type\MerchantInformationType $MerchantInformation
     * @return CancelCheckInRequestType
     */
    public function withMerchantInformation($MerchantInformation)
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

    /**
     * @param string $Reason
     * @return CancelCheckInRequestType
     */
    public function withReason($Reason)
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

    /**
     * @param string $CustomerRelationUuid
     * @return CancelCheckInRequestType
     */
    public function withCustomerRelationUuid($CustomerRelationUuid)
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

    /**
     * @param string $PairingUuid
     * @return CancelCheckInRequestType
     */
    public function withPairingUuid($PairingUuid)
    {
        $new = clone $this;
        $new->PairingUuid = $PairingUuid;

        return $new;
    }

    /**
     * @return \Twint\Sdk\Generated\Type\CouponListType
     */
    public function getCoupons()
    {
        return $this->Coupons;
    }

    /**
     * @param \Twint\Sdk\Generated\Type\CouponListType $Coupons
     * @return CancelCheckInRequestType
     */
    public function withCoupons($Coupons)
    {
        $new = clone $this;
        $new->Coupons = $Coupons;

        return $new;
    }
}

