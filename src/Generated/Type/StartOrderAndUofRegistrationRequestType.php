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

    public function withMerchantInformation(MerchantInformationType $MerchantInformation): self
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

    public function withRegistrationRequest(RegistrationRequestType $RegistrationRequest): self
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

    public function withOrder(OrderRequestType $Order): self
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

    public function withCoupons(CouponListType $Coupons): self
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

    public function withPaymentLayerRendering(string $PaymentLayerRendering): self
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

    public function withOrderUpdateNotificationURL(string $OrderUpdateNotificationURL): self
    {
        $new = clone $this;
        $new->OrderUpdateNotificationURL = $OrderUpdateNotificationURL;

        return $new;
    }
}
