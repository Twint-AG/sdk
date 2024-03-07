<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use Phpro\SoapClient\Type\RequestInterface;

final class StartOrderRequestType implements RequestInterface
{
    /**
     * @var MerchantInformationType
     */
    private $MerchantInformation;

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
     * @var ExpressMerchantAuthorizationType
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
     * @param MerchantInformationType $MerchantInformation
     * @param OrderRequestType $Order
     * @param CouponListType $Coupons
     * @param string $OfflineAuthorization
     * @param string $CustomerRelationUuid
     * @param string $PairingUuid
     * @param bool $UnidentifiedCustomer
     * @param ExpressMerchantAuthorizationType $ExpressMerchantAuthorization
     * @param bool $QRCodeRendering
     * @param string $PaymentLayerRendering
     * @param string $OrderUpdateNotificationURL
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
     * @return MerchantInformationType
     */
    public function getMerchantInformation()
    {
        return $this->MerchantInformation;
    }

    /**
     * @param MerchantInformationType $MerchantInformation
     * @return StartOrderRequestType
     */
    public function withMerchantInformation($MerchantInformation)
    {
        $new = clone $this;
        $new->MerchantInformation = $MerchantInformation;

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
     * @return StartOrderRequestType
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
     * @return ExpressMerchantAuthorizationType
     */
    public function getExpressMerchantAuthorization()
    {
        return $this->ExpressMerchantAuthorization;
    }

    /**
     * @param ExpressMerchantAuthorizationType $ExpressMerchantAuthorization
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
