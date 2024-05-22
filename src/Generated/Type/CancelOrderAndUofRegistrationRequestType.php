<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

class CancelOrderAndUofRegistrationRequestType
{
    /**
     * Restriction of the Base Merchant Information.
     *  In contrary to that it MUST contain a CashRegister Id. Used as the default type for operations
     *  within the *-POS Cases, where the Actions are performed by specific CashRegisters
     */
    protected MerchantInformationType $MerchantInformation;

    /**
     * Base type: restriction of xs:string Pattern: [A-Fa-f0-9]{32}|(\{|\()?[A-Fa-f0-9]{8}-([A-Fa-f0-9]{4}-){3}[A-Fa-f0-9]{12}(\}|\))? This type is used by other XML schema attributes or elements that will
     *  hold a universal unique identifier (UUID), commonly known as either a globally unique identifier (GUID) or UUID. The regular expression defined limits the contents of an attribute to either a
     *  single 32-digit hexadecimal string or a 32-digit hex string patterned as [8]-[4]-[4]-[4]-[12] digits.
     */
    protected ?string $PaymentOrderUuid = null;

    /**
     * Reference number by which the merchant might want to identify
     *  this voucher in his own applications.
     */
    protected ?string $MerchantTransactionReference = null;

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

    public function getPaymentOrderUuid(): ?string
    {
        return $this->PaymentOrderUuid;
    }

    public function withPaymentOrderUuid(?string $PaymentOrderUuid): static
    {
        $new = clone $this;
        $new->PaymentOrderUuid = $PaymentOrderUuid;

        return $new;
    }

    public function getMerchantTransactionReference(): ?string
    {
        return $this->MerchantTransactionReference;
    }

    public function withMerchantTransactionReference(?string $MerchantTransactionReference): static
    {
        $new = clone $this;
        $new->MerchantTransactionReference = $MerchantTransactionReference;

        return $new;
    }
}
