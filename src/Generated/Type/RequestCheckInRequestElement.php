<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use Phpro\SoapClient\Type\RequestInterface;

class RequestCheckInRequestElement implements RequestInterface
{
    /**
     * Restriction of the Base Merchant Information.
     *  In contrary to that it MUST contain a CashRegister Id. Used as the default type for operations
     *  within the *-POS Cases, where the Actions are performed by specific CashRegisters
     */
    protected MerchantInformationType $MerchantInformation;

    protected ?string $OfflineAuthorization = null;

    protected ?string $CouponCode = null;

    /**
     * Base type: restriction of xs:string Pattern: [A-Fa-f0-9]{32}|(\{|\()?[A-Fa-f0-9]{8}-([A-Fa-f0-9]{4}-){3}[A-Fa-f0-9]{12}(\}|\))? This type is used by other XML schema attributes or elements that will
     *  hold a universal unique identifier (UUID), commonly known as either a globally unique identifier (GUID) or UUID. The regular expression defined limits the contents of an attribute to either a
     *  single 32-digit hexadecimal string or a 32-digit hex string patterned as [8]-[4]-[4]-[4]-[12] digits.
     */
    protected ?string $CustomerRelationUuid = null;

    protected ?bool $UnidentifiedCustomer = null;

    protected ?LoyaltyType $LoyaltyInformation = null;

    /**
     * @var null | 'NONE' | 'LIST_COUPONS' | 'RECURRING_PAYMENT'
     */
    protected ?string $RequestCustomerRelationAlias = null;

    protected ?bool $QRCodeRendering = null;

    /**
     * @param null | 'NONE' | 'LIST_COUPONS' | 'RECURRING_PAYMENT' $RequestCustomerRelationAlias
     */
    public function __construct(MerchantInformationType $MerchantInformation, ?string $OfflineAuthorization, ?string $CouponCode, ?string $CustomerRelationUuid, ?bool $UnidentifiedCustomer, ?LoyaltyType $LoyaltyInformation, ?string $RequestCustomerRelationAlias, ?bool $QRCodeRendering)
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

    public function getCouponCode(): ?string
    {
        return $this->CouponCode;
    }

    public function withCouponCode(?string $CouponCode): static
    {
        $new = clone $this;
        $new->CouponCode = $CouponCode;

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

    public function getLoyaltyInformation(): ?LoyaltyType
    {
        return $this->LoyaltyInformation;
    }

    public function withLoyaltyInformation(?LoyaltyType $LoyaltyInformation): static
    {
        $new = clone $this;
        $new->LoyaltyInformation = $LoyaltyInformation;

        return $new;
    }

    /**
     * @return null | 'NONE' | 'LIST_COUPONS' | 'RECURRING_PAYMENT'
     */
    public function getRequestCustomerRelationAlias(): ?string
    {
        return $this->RequestCustomerRelationAlias;
    }

    /**
     * @param null | 'NONE' | 'LIST_COUPONS' | 'RECURRING_PAYMENT' $RequestCustomerRelationAlias
     */
    public function withRequestCustomerRelationAlias(?string $RequestCustomerRelationAlias): static
    {
        $new = clone $this;
        $new->RequestCustomerRelationAlias = $RequestCustomerRelationAlias;

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
}
