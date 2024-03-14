<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use Phpro\SoapClient\Type\RequestInterface;

class StartOrderAndUofRegistrationRequestType implements RequestInterface
{
    /**
     * Restriction of the Base Merchant Information.
     *  In contrary to that it MUST contain a CashRegister Id. Used as the default type for operations
     *  within the *-POS Cases, where the Actions are performed by specific CashRegisters
     */
    protected MerchantInformationType $MerchantInformation;

    /**
     * Required information for UOF registration>
     */
    protected RegistrationRequestType $RegistrationRequest;

    protected OrderRequestType $Order;

    protected ?CouponListType $Coupons;

    /**
     * @var null | 'QR_CODE' | 'PAYMENT_PAGE'
     */
    protected ?string $PaymentLayerRendering;

    protected ?string $OrderUpdateNotificationURL;

    /**
     * Constructor
     *
     * @param null | 'QR_CODE' | 'PAYMENT_PAGE' $PaymentLayerRendering
     */
    public function __construct(MerchantInformationType $MerchantInformation, RegistrationRequestType $RegistrationRequest, OrderRequestType $Order, ?CouponListType $Coupons, ?string $PaymentLayerRendering, ?string $OrderUpdateNotificationURL)
    {
        $this->MerchantInformation = $MerchantInformation;
        $this->RegistrationRequest = $RegistrationRequest;
        $this->Order = $Order;
        $this->Coupons = $Coupons;
        $this->PaymentLayerRendering = $PaymentLayerRendering;
        $this->OrderUpdateNotificationURL = $OrderUpdateNotificationURL;
    }

    public function getMerchantInformation(): MerchantInformationType
    {
        return $this->MerchantInformation;
    }

    public function withMerchantInformation(MerchantInformationType $MerchantInformation): static
    {
        $new = clone $this;
        $new->MerchantInformation = $MerchantInformation;

        return $new;
    }

    public function getRegistrationRequest(): RegistrationRequestType
    {
        return $this->RegistrationRequest;
    }

    public function withRegistrationRequest(RegistrationRequestType $RegistrationRequest): static
    {
        $new = clone $this;
        $new->RegistrationRequest = $RegistrationRequest;

        return $new;
    }

    public function getOrder(): OrderRequestType
    {
        return $this->Order;
    }

    public function withOrder(OrderRequestType $Order): static
    {
        $new = clone $this;
        $new->Order = $Order;

        return $new;
    }

    public function getCoupons(): ?CouponListType
    {
        return $this->Coupons;
    }

    public function withCoupons(?CouponListType $Coupons): static
    {
        $new = clone $this;
        $new->Coupons = $Coupons;

        return $new;
    }

    /**
     * @return null | 'QR_CODE' | 'PAYMENT_PAGE'
     */
    public function getPaymentLayerRendering(): ?string
    {
        return $this->PaymentLayerRendering;
    }

    /**
     * @param null | 'QR_CODE' | 'PAYMENT_PAGE' $PaymentLayerRendering
     */
    public function withPaymentLayerRendering(?string $PaymentLayerRendering): static
    {
        $new = clone $this;
        $new->PaymentLayerRendering = $PaymentLayerRendering;

        return $new;
    }

    public function getOrderUpdateNotificationURL(): ?string
    {
        return $this->OrderUpdateNotificationURL;
    }

    public function withOrderUpdateNotificationURL(?string $OrderUpdateNotificationURL): static
    {
        $new = clone $this;
        $new->OrderUpdateNotificationURL = $OrderUpdateNotificationURL;

        return $new;
    }
}
