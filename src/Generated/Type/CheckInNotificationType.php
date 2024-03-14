<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

class CheckInNotificationType
{
    /**
     * Restriction of the Base Merchant Information.
     *  In contrary to that it MUST contain a CashRegister Id. Used as the default type for operations
     *  within the *-POS Cases, where the Actions are performed by specific CashRegisters
     */
    protected MerchantInformationType $MerchantInformation;

    protected ?CustomerInformationType $CustomerInformation;

    /**
     * Base type: restriction of xs:string Pattern: [A-Fa-f0-9]{32}|(\{|\()?[A-Fa-f0-9]{8}-([A-Fa-f0-9]{4}-){3}[A-Fa-f0-9]{12}(\}|\))? This type is used by other XML schema attributes or elements that will
     *  hold a universal unique identifier (UUID), commonly known as either a globally unique identifier (GUID) or UUID. The regular expression defined limits the contents of an attribute to either a
     *  single 32-digit hexadecimal string or a 32-digit hex string patterned as [8]-[4]-[4]-[4]-[12] digits.
     */
    protected ?string $PairingUuid;

    /**
     * @var 'NO_PAIRING' | 'PAIRING_IN_PROGRESS' | 'PAIRING_ACTIVE'
     */
    protected string $PairingStatus;

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

    public function getCustomerInformation(): ?CustomerInformationType
    {
        return $this->CustomerInformation;
    }

    public function withCustomerInformation(?CustomerInformationType $CustomerInformation): static
    {
        $new = clone $this;
        $new->CustomerInformation = $CustomerInformation;

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
}
