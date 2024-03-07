<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use Phpro\SoapClient\Type\RequestInterface;

final class RequestCheckInRequestType implements RequestInterface
{
    /**
     * @var MerchantInformationType
     */
    private $MerchantInformation;

    /**
     * @var string
     */
    private $OfflineAuthorization;

    /**
     * @var string
     */
    private $CouponCode;

    /**
     * @var string
     */
    private $CustomerRelationUuid;

    /**
     * @var bool
     */
    private $UnidentifiedCustomer;

    /**
     * @var LoyaltyType
     */
    private $LoyaltyInformation;

    /**
     * @var string
     */
    private $RequestCustomerRelationAlias;

    /**
     * @var bool
     */
    private $QRCodeRendering;

    /**
     * Constructor
     *
     * @param MerchantInformationType $MerchantInformation
     * @param string $OfflineAuthorization
     * @param string $CouponCode
     * @param string $CustomerRelationUuid
     * @param bool $UnidentifiedCustomer
     * @param LoyaltyType $LoyaltyInformation
     * @param string $RequestCustomerRelationAlias
     * @param bool $QRCodeRendering
     */
    public function __construct($MerchantInformation, $OfflineAuthorization, $CouponCode, $CustomerRelationUuid, $UnidentifiedCustomer, $LoyaltyInformation, $RequestCustomerRelationAlias, $QRCodeRendering)
    {
        $this->MerchantInformation = $MerchantInformation;
        $this->OfflineAuthorization = $OfflineAuthorization;
        $this->CouponCode = $CouponCode;
        $this->CustomerRelationUuid = $CustomerRelationUuid;
        $this->UnidentifiedCustomer = $UnidentifiedCustomer;
        $this->LoyaltyInformation = $LoyaltyInformation;
        $this->RequestCustomerRelationAlias = $RequestCustomerRelationAlias;
        $this->QRCodeRendering = $QRCodeRendering;
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
     * @return RequestCheckInRequestType
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
    public function getOfflineAuthorization()
    {
        return $this->OfflineAuthorization;
    }

    /**
     * @param string $OfflineAuthorization
     * @return RequestCheckInRequestType
     */
    public function withOfflineAuthorization($OfflineAuthorization)
    {
        $new = clone $this;
        $new->OfflineAuthorization = $OfflineAuthorization;

        return $new;
    }

    /**
     * @return string
     */
    public function getCouponCode()
    {
        return $this->CouponCode;
    }

    /**
     * @param string $CouponCode
     * @return RequestCheckInRequestType
     */
    public function withCouponCode($CouponCode)
    {
        $new = clone $this;
        $new->CouponCode = $CouponCode;

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
     * @return RequestCheckInRequestType
     */
    public function withCustomerRelationUuid($CustomerRelationUuid)
    {
        $new = clone $this;
        $new->CustomerRelationUuid = $CustomerRelationUuid;

        return $new;
    }

    /**
     * @return bool
     */
    public function getUnidentifiedCustomer()
    {
        return $this->UnidentifiedCustomer;
    }

    /**
     * @param bool $UnidentifiedCustomer
     * @return RequestCheckInRequestType
     */
    public function withUnidentifiedCustomer($UnidentifiedCustomer)
    {
        $new = clone $this;
        $new->UnidentifiedCustomer = $UnidentifiedCustomer;

        return $new;
    }

    /**
     * @return LoyaltyType
     */
    public function getLoyaltyInformation()
    {
        return $this->LoyaltyInformation;
    }

    /**
     * @param LoyaltyType $LoyaltyInformation
     * @return RequestCheckInRequestType
     */
    public function withLoyaltyInformation($LoyaltyInformation)
    {
        $new = clone $this;
        $new->LoyaltyInformation = $LoyaltyInformation;

        return $new;
    }

    /**
     * @return string
     */
    public function getRequestCustomerRelationAlias()
    {
        return $this->RequestCustomerRelationAlias;
    }

    /**
     * @param string $RequestCustomerRelationAlias
     * @return RequestCheckInRequestType
     */
    public function withRequestCustomerRelationAlias($RequestCustomerRelationAlias)
    {
        $new = clone $this;
        $new->RequestCustomerRelationAlias = $RequestCustomerRelationAlias;

        return $new;
    }

    /**
     * @return bool
     */
    public function getQRCodeRendering()
    {
        return $this->QRCodeRendering;
    }

    /**
     * @param bool $QRCodeRendering
     * @return RequestCheckInRequestType
     */
    public function withQRCodeRendering($QRCodeRendering)
    {
        $new = clone $this;
        $new->QRCodeRendering = $QRCodeRendering;

        return $new;
    }
}
