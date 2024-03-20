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

    public function withMerchantInformation(MerchantInformationType $MerchantInformation): self
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

    public function withOfflineAuthorization(string $OfflineAuthorization): self
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

    public function withCouponCode(string $CouponCode): self
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

    public function withCustomerRelationUuid(string $CustomerRelationUuid): self
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

    public function withUnidentifiedCustomer(bool $UnidentifiedCustomer): self
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

    public function withLoyaltyInformation(LoyaltyType $LoyaltyInformation): self
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

    public function withRequestCustomerRelationAlias(string $RequestCustomerRelationAlias): self
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

    public function withQRCodeRendering(bool $QRCodeRendering): self
    {
        $new = clone $this;
        $new->QRCodeRendering = $QRCodeRendering;

        return $new;
    }
}
