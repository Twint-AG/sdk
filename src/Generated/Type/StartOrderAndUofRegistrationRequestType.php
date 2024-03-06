<?php

namespace Twint\Sdk\Generated\Type;

use Phpro\SoapClient\Type\RequestInterface;

class StartOrderAndUofRegistrationRequestType implements RequestInterface
{
    /**
     * @var \Twint\Sdk\Generated\Type\MerchantInformationType
     */
    private $MerchantInformation;

    /**
     * @var \Twint\Sdk\Generated\Type\RegistrationRequestType
     */
    private $RegistrationRequest;

    /**
     * @var \Twint\Sdk\Generated\Type\OrderRequestType
     */
    private $Order;

    /**
     * @var \Twint\Sdk\Generated\Type\CouponListType
     */
    private $Coupons;

    /**
     * @var string
     */
    private $PaymentLayerRendering;

    /**
     * @var string
     */
    private $OrderUpdateNotificationURL;

    /**
     * Constructor
     *
     * @var \Twint\Sdk\Generated\Type\MerchantInformationType $MerchantInformation
     * @var \Twint\Sdk\Generated\Type\RegistrationRequestType $RegistrationRequest
     * @var \Twint\Sdk\Generated\Type\OrderRequestType $Order
     * @var \Twint\Sdk\Generated\Type\CouponListType $Coupons
     * @var string $PaymentLayerRendering
     * @var string $OrderUpdateNotificationURL
     */
    public function __construct($MerchantInformation, $RegistrationRequest, $Order, $Coupons, $PaymentLayerRendering, $OrderUpdateNotificationURL)
    {
        $this->MerchantInformation = $MerchantInformation;
        $this->RegistrationRequest = $RegistrationRequest;
        $this->Order = $Order;
        $this->Coupons = $Coupons;
        $this->PaymentLayerRendering = $PaymentLayerRendering;
        $this->OrderUpdateNotificationURL = $OrderUpdateNotificationURL;
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
     * @return StartOrderAndUofRegistrationRequestType
     */
    public function withMerchantInformation($MerchantInformation)
    {
        $new = clone $this;
        $new->MerchantInformation = $MerchantInformation;

        return $new;
    }

    /**
     * @return \Twint\Sdk\Generated\Type\RegistrationRequestType
     */
    public function getRegistrationRequest()
    {
        return $this->RegistrationRequest;
    }

    /**
     * @param \Twint\Sdk\Generated\Type\RegistrationRequestType $RegistrationRequest
     * @return StartOrderAndUofRegistrationRequestType
     */
    public function withRegistrationRequest($RegistrationRequest)
    {
        $new = clone $this;
        $new->RegistrationRequest = $RegistrationRequest;

        return $new;
    }

    /**
     * @return \Twint\Sdk\Generated\Type\OrderRequestType
     */
    public function getOrder()
    {
        return $this->Order;
    }

    /**
     * @param \Twint\Sdk\Generated\Type\OrderRequestType $Order
     * @return StartOrderAndUofRegistrationRequestType
     */
    public function withOrder($Order)
    {
        $new = clone $this;
        $new->Order = $Order;

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
     * @return StartOrderAndUofRegistrationRequestType
     */
    public function withCoupons($Coupons)
    {
        $new = clone $this;
        $new->Coupons = $Coupons;

        return $new;
    }

    /**
     * @return string
     */
    public function getPaymentLayerRendering()
    {
        return $this->PaymentLayerRendering;
    }

    /**
     * @param string $PaymentLayerRendering
     * @return StartOrderAndUofRegistrationRequestType
     */
    public function withPaymentLayerRendering($PaymentLayerRendering)
    {
        $new = clone $this;
        $new->PaymentLayerRendering = $PaymentLayerRendering;

        return $new;
    }

    /**
     * @return string
     */
    public function getOrderUpdateNotificationURL()
    {
        return $this->OrderUpdateNotificationURL;
    }

    /**
     * @param string $OrderUpdateNotificationURL
     * @return StartOrderAndUofRegistrationRequestType
     */
    public function withOrderUpdateNotificationURL($OrderUpdateNotificationURL)
    {
        $new = clone $this;
        $new->OrderUpdateNotificationURL = $OrderUpdateNotificationURL;

        return $new;
    }
}

