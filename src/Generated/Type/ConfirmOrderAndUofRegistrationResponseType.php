<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use Phpro\SoapClient\Type\ResultInterface;

class ConfirmOrderAndUofRegistrationResponseType implements ResultInterface
{
    /**
     * Restriction of the Base Merchant Information.
     *  In contrary to that it MUST contain a CashRegister Id. Used as the default type for operations
     *  within the *-POS Cases, where the Actions are performed by specific CashRegisters
     */
    protected MerchantInformationType $MerchantInformation;

    /**
     * @var 'NO_PAIRING' | 'PAIRING_IN_PROGRESS' | 'PAIRING_ACTIVE'
     */
    protected string $PairingStatus;

    /**
     * Base type: restriction of xs:string Pattern: [A-Fa-f0-9]{32}|(\{|\()?[A-Fa-f0-9]{8}-([A-Fa-f0-9]{4}-){3}[A-Fa-f0-9]{12}(\}|\))? This type is used by other XML schema attributes or elements that will
     *  hold a universal unique identifier (UUID), commonly known as either a globally unique identifier (GUID) or UUID. The regular expression defined limits the contents of an attribute to either a
     *  single 32-digit hexadecimal string or a 32-digit hex string patterned as [8]-[4]-[4]-[4]-[12] digits.
     */
    protected string $PaymentOrderUuid;

    protected OrderType $PaymentOrder;

    /**
     * Base type: restriction of xs:string Pattern: [A-Fa-f0-9]{32}|(\{|\()?[A-Fa-f0-9]{8}-([A-Fa-f0-9]{4}-){3}[A-Fa-f0-9]{12}(\}|\))? This type is used by other XML schema attributes or elements that will
     *  hold a universal unique identifier (UUID), commonly known as either a globally unique identifier (GUID) or UUID. The regular expression defined limits the contents of an attribute to either a
     *  single 32-digit hexadecimal string or a 32-digit hex string patterned as [8]-[4]-[4]-[4]-[12] digits.
     */
    protected string $RegistrationUuid;

    protected RegistrationType $RegistrationOrder;

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
     * @return 'NO_PAIRING' | 'PAIRING_IN_PROGRESS' | 'PAIRING_ACTIVE'
     */
    public function getPairingStatus(): string
    {
        return $this->PairingStatus;
    }

    /**
     * @param 'NO_PAIRING' | 'PAIRING_IN_PROGRESS' | 'PAIRING_ACTIVE' $PairingStatus
     */
    public function withPairingStatus(string $PairingStatus): static
    {
        $new = clone $this;
        $new->PairingStatus = $PairingStatus;

        return $new;
    }

    public function getPaymentOrderUuid(): string
    {
        return $this->PaymentOrderUuid;
    }

    public function withPaymentOrderUuid(string $PaymentOrderUuid): static
    {
        $new = clone $this;
        $new->PaymentOrderUuid = $PaymentOrderUuid;

        return $new;
    }

    public function getPaymentOrder(): OrderType
    {
        return $this->PaymentOrder;
    }

    public function withPaymentOrder(OrderType $PaymentOrder): static
    {
        $new = clone $this;
        $new->PaymentOrder = $PaymentOrder;

        return $new;
    }

    public function getRegistrationUuid(): string
    {
        return $this->RegistrationUuid;
    }

    public function withRegistrationUuid(string $RegistrationUuid): static
    {
        $new = clone $this;
        $new->RegistrationUuid = $RegistrationUuid;

        return $new;
    }

    public function getRegistrationOrder(): RegistrationType
    {
        return $this->RegistrationOrder;
    }

    public function withRegistrationOrder(RegistrationType $RegistrationOrder): static
    {
        $new = clone $this;
        $new->RegistrationOrder = $RegistrationOrder;

        return $new;
    }
}
