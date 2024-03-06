<?php

namespace Twint\Sdk\Generated\Type;

use Phpro\SoapClient\Type\RequestInterface;

class RequestFastCheckoutCheckInRequestType implements RequestInterface
{
    /**
     * @var \Twint\Sdk\Generated\Type\MerchantInformationType
     */
    private $MerchantInformation;

    /**
     * @var \Twint\Sdk\Generated\Type\CurrencyAmountType
     */
    private $NetAmount;

    /**
     * @var string
     */
    private $RequestedScopes;

    /**
     * @var \Twint\Sdk\Generated\Type\ShippingMethodReferenceType
     */
    private $ShippingMethods;

    /**
     * @var bool
     */
    private $QRCodeRendering;

    /**
     * Constructor
     *
     * @var \Twint\Sdk\Generated\Type\MerchantInformationType $MerchantInformation
     * @var \Twint\Sdk\Generated\Type\CurrencyAmountType $NetAmount
     * @var string $RequestedScopes
     * @var \Twint\Sdk\Generated\Type\ShippingMethodReferenceType $ShippingMethods
     * @var bool $QRCodeRendering
     */
    public function __construct($MerchantInformation, $NetAmount, $RequestedScopes, $ShippingMethods, $QRCodeRendering)
    {
        $this->MerchantInformation = $MerchantInformation;
        $this->NetAmount = $NetAmount;
        $this->RequestedScopes = $RequestedScopes;
        $this->ShippingMethods = $ShippingMethods;
        $this->QRCodeRendering = $QRCodeRendering;
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
     * @return RequestFastCheckoutCheckInRequestType
     */
    public function withMerchantInformation($MerchantInformation)
    {
        $new = clone $this;
        $new->MerchantInformation = $MerchantInformation;

        return $new;
    }

    /**
     * @return \Twint\Sdk\Generated\Type\CurrencyAmountType
     */
    public function getNetAmount()
    {
        return $this->NetAmount;
    }

    /**
     * @param \Twint\Sdk\Generated\Type\CurrencyAmountType $NetAmount
     * @return RequestFastCheckoutCheckInRequestType
     */
    public function withNetAmount($NetAmount)
    {
        $new = clone $this;
        $new->NetAmount = $NetAmount;

        return $new;
    }

    /**
     * @return string
     */
    public function getRequestedScopes()
    {
        return $this->RequestedScopes;
    }

    /**
     * @param string $RequestedScopes
     * @return RequestFastCheckoutCheckInRequestType
     */
    public function withRequestedScopes($RequestedScopes)
    {
        $new = clone $this;
        $new->RequestedScopes = $RequestedScopes;

        return $new;
    }

    /**
     * @return \Twint\Sdk\Generated\Type\ShippingMethodReferenceType
     */
    public function getShippingMethods()
    {
        return $this->ShippingMethods;
    }

    /**
     * @param \Twint\Sdk\Generated\Type\ShippingMethodReferenceType $ShippingMethods
     * @return RequestFastCheckoutCheckInRequestType
     */
    public function withShippingMethods($ShippingMethods)
    {
        $new = clone $this;
        $new->ShippingMethods = $ShippingMethods;

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
     * @return RequestFastCheckoutCheckInRequestType
     */
    public function withQRCodeRendering($QRCodeRendering)
    {
        $new = clone $this;
        $new->QRCodeRendering = $QRCodeRendering;

        return $new;
    }
}

