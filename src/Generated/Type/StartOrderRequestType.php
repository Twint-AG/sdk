<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

class StartOrderRequestType
{
    /**
     * Restriction of the Base Merchant Information.
     *  In contrary to that it MUST contain a CashRegister Id. Used as the default type for operations
     *  within the *-POS Cases, where the Actions are performed by specific CashRegisters
     */
    protected MerchantInformationType $MerchantInformation;

    protected OrderRequestType $Order;

    protected ?CouponListType $Coupons = null;

    protected ?string $OfflineAuthorization = null;

    /**
     * Base type: restriction of xs:string Pattern: [A-Fa-f0-9]{32}|(\{|\()?[A-Fa-f0-9]{8}-([A-Fa-f0-9]{4}-){3}[A-Fa-f0-9]{12}(\}|\))? This type is used by other XML schema attributes or elements that will
     *  hold a universal unique identifier (UUID), commonly known as either a globally unique identifier (GUID) or UUID. The regular expression defined limits the contents of an attribute to either a
     *  single 32-digit hexadecimal string or a 32-digit hex string patterned as [8]-[4]-[4]-[4]-[12] digits.
     */
    protected ?string $CustomerRelationUuid = null;

    /**
     * Base type: restriction of xs:string Pattern: [A-Fa-f0-9]{32}|(\{|\()?[A-Fa-f0-9]{8}-([A-Fa-f0-9]{4}-){3}[A-Fa-f0-9]{12}(\}|\))? This type is used by other XML schema attributes or elements that will
     *  hold a universal unique identifier (UUID), commonly known as either a globally unique identifier (GUID) or UUID. The regular expression defined limits the contents of an attribute to either a
     *  single 32-digit hexadecimal string or a 32-digit hex string patterned as [8]-[4]-[4]-[4]-[12] digits.
     */
    protected ?string $PairingUuid = null;

    protected ?bool $UnidentifiedCustomer = null;

    protected ?ExpressMerchantAuthorizationType $ExpressMerchantAuthorization = null;

    protected ?bool $QRCodeRendering = null;

    /**
     * @var null | 'QR_CODE' | 'PAYMENT_PAGE'
     */
    protected ?string $PaymentLayerRendering = null;

    protected ?string $OrderUpdateNotificationURL = null;

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

    public function getOfflineAuthorization(): ?string
    {
        return $this->OfflineAuthorization;
    }

    public function withOfflineAuthorization(?string $OfflineAuthorization): static
    {
        $new = clone $this;
        $new->OfflineAuthorization = $OfflineAuthorization;

        return $new;
    }

    public function getCustomerRelationUuid(): ?string
    {
        return $this->CustomerRelationUuid;
    }

    public function withCustomerRelationUuid(?string $CustomerRelationUuid): static
    {
        $new = clone $this;
        $new->CustomerRelationUuid = $CustomerRelationUuid;

        return $new;
    }

    public function getPairingUuid(): ?string
    {
        return $this->PairingUuid;
    }

    public function withPairingUuid(?string $PairingUuid): static
    {
        $new = clone $this;
        $new->PairingUuid = $PairingUuid;

        return $new;
    }

    public function getUnidentifiedCustomer(): ?bool
    {
        return $this->UnidentifiedCustomer;
    }

    public function withUnidentifiedCustomer(?bool $UnidentifiedCustomer): static
    {
        $new = clone $this;
        $new->UnidentifiedCustomer = $UnidentifiedCustomer;

        return $new;
    }

    public function getExpressMerchantAuthorization(): ?ExpressMerchantAuthorizationType
    {
        return $this->ExpressMerchantAuthorization;
    }

    public function withExpressMerchantAuthorization(
        ?ExpressMerchantAuthorizationType $ExpressMerchantAuthorization
    ): static {
        $new = clone $this;
        $new->ExpressMerchantAuthorization = $ExpressMerchantAuthorization;

        return $new;
    }

    public function getQRCodeRendering(): ?bool
    {
        return $this->QRCodeRendering;
    }

    public function withQRCodeRendering(?bool $QRCodeRendering): static
    {
        $new = clone $this;
        $new->QRCodeRendering = $QRCodeRendering;

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
