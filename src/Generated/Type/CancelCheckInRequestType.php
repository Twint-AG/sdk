<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use AllowDynamicProperties;
use Phpro\SoapClient\Type\RequestInterface;

#[AllowDynamicProperties]
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

    /**
     * @param MerchantInformationType $MerchantInformation
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
     * @return CouponListType
     */
    public function getCoupons()
    {
        return $this->Coupons;
    }

    /**
     * @param CouponListType $Coupons
     * @return CancelCheckInRequestType
     */
    public function withCoupons($Coupons)
    {
        $new = clone $this;
        $new->Coupons = $Coupons;

        return $new;
    }
}
