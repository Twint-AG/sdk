<?php

namespace Twint\Sdk\Generated\Type;

use Phpro\SoapClient\Type\RequestInterface;

class StartOrderRequestType implements RequestInterface
{
    /**
     * @var \Twint\Sdk\Generated\Type\MerchantInformationType
     */
    private $MerchantInformation;

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
    private $OfflineAuthorization;

    /**
     * @var string
     */
    private $CustomerRelationUuid;

    /**
     * @var string
     */
    private $PairingUuid;

    /**
     * @var bool
     */
    private $UnidentifiedCustomer;

    /**
     * @var \Twint\Sdk\Generated\Type\ExpressMerchantAuthorizationType
     */
    private $ExpressMerchantAuthorization;

    /**
     * @var bool
     */
    private $QRCodeRendering;

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
     * @var \Twint\Sdk\Generated\Type\OrderRequestType $Order
     * @var \Twint\Sdk\Generated\Type\CouponListType $Coupons
     * @var string $OfflineAuthorization
     * @var string $CustomerRelationUuid
     * @var string $PairingUuid
     * @var bool $UnidentifiedCustomer
     * @var \Twint\Sdk\Generated\Type\ExpressMerchantAuthorizationType $ExpressMerchantAuthorization
     * @var bool $QRCodeRendering
     * @var string $PaymentLayerRendering
     * @var string $OrderUpdateNotificationURL
     */
    public function __construct($MerchantInformation, $Order, $Coupons, $OfflineAuthorization, $CustomerRelationUuid, $PairingUuid, $UnidentifiedCustomer, $ExpressMerchantAuthorization, $QRCodeRendering, $PaymentLayerRendering, $OrderUpdateNotificationURL)
    {
        $this->MerchantInformation = $MerchantInformation;
        $this->Order = $Order;
        $this->Coupons = $Coupons;
        $this->OfflineAuthorization = $OfflineAuthorization;
        $this->CustomerRelationUuid = $CustomerRelationUuid;
        $this->PairingUuid = $PairingUuid;
        $this->UnidentifiedCustomer = $UnidentifiedCustomer;
        $this->ExpressMerchantAuthorization = $ExpressMerchantAuthorization;
        $this->QRCodeRendering = $QRCodeRendering;
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
     * @return StartOrderRequestType
     */
    public function withMerchantInformation($MerchantInformation)
    {
        $new = clone $this;
        $new->MerchantInformation = $MerchantInformation;

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
     * @return StartOrderRequestType
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
     * @return StartOrderRequestType
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
    public function getOfflineAuthorization()
    {
        return $this->OfflineAuthorization;
    }

    /**
     * @param string $OfflineAuthorization
     * @return StartOrderRequestType
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
    public function getCustomerRelationUuid()
    {
        return $this->CustomerRelationUuid;
    }

    /**
     * @param string $CustomerRelationUuid
     * @return StartOrderRequestType
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
     * @return StartOrderRequestType
     */
    public function withPairingUuid($PairingUuid)
    {
        $new = clone $this;
        $new->PairingUuid = $PairingUuid;

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
     * @return StartOrderRequestType
     */
    public function withUnidentifiedCustomer($UnidentifiedCustomer)
    {
        $new = clone $this;
        $new->UnidentifiedCustomer = $UnidentifiedCustomer;

        return $new;
    }

    /**
     * @return \Twint\Sdk\Generated\Type\ExpressMerchantAuthorizationType
     */
    public function getExpressMerchantAuthorization()
    {
        return $this->ExpressMerchantAuthorization;
    }

    /**
     * @param \Twint\Sdk\Generated\Type\ExpressMerchantAuthorizationType $ExpressMerchantAuthorization
     * @return StartOrderRequestType
     */
    public function withExpressMerchantAuthorization($ExpressMerchantAuthorization)
    {
        $new = clone $this;
        $new->ExpressMerchantAuthorization = $ExpressMerchantAuthorization;

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
     * @return StartOrderRequestType
     */
    public function withQRCodeRendering($QRCodeRendering)
    {
        $new = clone $this;
        $new->QRCodeRendering = $QRCodeRendering;

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
     * @return StartOrderRequestType
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
     * @return StartOrderRequestType
     */
    public function withOrderUpdateNotificationURL($OrderUpdateNotificationURL)
    {
        $new = clone $this;
        $new->OrderUpdateNotificationURL = $OrderUpdateNotificationURL;

        return $new;
    }
}

