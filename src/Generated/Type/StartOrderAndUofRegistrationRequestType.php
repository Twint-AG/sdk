<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use Phpro\SoapClient\Type\RequestInterface;

final class StartOrderAndUofRegistrationRequestType implements RequestInterface
{
    /**
     * @var MerchantInformationType
     */
    private $MerchantInformation;

    /**
     * @var RegistrationRequestType
     */
    private $RegistrationRequest;

    /**
     * @var OrderRequestType
     */
    private $Order;

    /**
     * @var CouponListType
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
     * @param MerchantInformationType $MerchantInformation
     * @param RegistrationRequestType $RegistrationRequest
     * @param OrderRequestType $Order
     * @param CouponListType $Coupons
     * @param string $PaymentLayerRendering
     * @param string $OrderUpdateNotificationURL
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
     * @return MerchantInformationType
     */
    public function getMerchantInformation()
    {
        return $this->MerchantInformation;
    }

    /**
     * @param MerchantInformationType $MerchantInformation
     * @return StartOrderAndUofRegistrationRequestType
     */
    public function withMerchantInformation($MerchantInformation)
    {
        $new = clone $this;
        $new->MerchantInformation = $MerchantInformation;

        return $new;
    }

    /**
     * @return RegistrationRequestType
     */
    public function getRegistrationRequest()
    {
        return $this->RegistrationRequest;
    }

    /**
     * @param RegistrationRequestType $RegistrationRequest
     * @return StartOrderAndUofRegistrationRequestType
     */
    public function withRegistrationRequest($RegistrationRequest)
    {
        $new = clone $this;
        $new->RegistrationRequest = $RegistrationRequest;

        return $new;
    }

    /**
     * @return OrderRequestType
     */
    public function getOrder()
    {
        return $this->Order;
    }

    /**
     * @param OrderRequestType $Order
     * @return StartOrderAndUofRegistrationRequestType
     */
    public function withOrder($Order)
    {
        $new = clone $this;
        $new->Order = $Order;

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
