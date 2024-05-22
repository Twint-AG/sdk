<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use Phpro\SoapClient\Type\RequestInterface;

class CancelCheckInRequestElement implements RequestInterface
{
    /**
     * Restriction of the Base Merchant Information.
     *  In contrary to that it MUST contain a CashRegister Id. Used as the default type for operations
     *  within the *-POS Cases, where the Actions are performed by specific CashRegisters
     */
    protected MerchantInformationType $MerchantInformation;

    /**
     * @var 'INVALID_PAIRING' | 'OTHER_PAYMENT_METHOD' | 'PAYMENT_ABORT' | 'NO_PAYMENT_NEEDED'
     */
    protected string $Reason;

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

    protected ?CouponListType $Coupons = null;

    /**
     * Constructor
     *
     * @param 'INVALID_PAIRING' | 'OTHER_PAYMENT_METHOD' | 'PAYMENT_ABORT' | 'NO_PAYMENT_NEEDED' $Reason
     */
    public function __construct(MerchantInformationType $MerchantInformation, string $Reason, ?string $CustomerRelationUuid, ?string $PairingUuid, ?CouponListType $Coupons)
    {
        $this->MerchantInformation = $MerchantInformation;
        $this->Reason = $Reason;
        $this->CustomerRelationUuid = $CustomerRelationUuid;
        $this->PairingUuid = $PairingUuid;
        $this->Coupons = $Coupons;
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

    /**
     * @return 'INVALID_PAIRING' | 'OTHER_PAYMENT_METHOD' | 'PAYMENT_ABORT' | 'NO_PAYMENT_NEEDED'
     */
    public function getReason(): string
    {
        return $this->Reason;
    }

    /**
     * @param 'INVALID_PAIRING' | 'OTHER_PAYMENT_METHOD' | 'PAYMENT_ABORT' | 'NO_PAYMENT_NEEDED' $Reason
     */
    public function withReason(string $Reason): static
    {
        $new = clone $this;
        $new->Reason = $Reason;

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
}
