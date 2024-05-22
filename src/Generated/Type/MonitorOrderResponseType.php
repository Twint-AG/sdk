<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use Phpro\SoapClient\Type\ResultInterface;

class MonitorOrderResponseType implements ResultInterface
{
    /**
     * Restriction of the Base Merchant Information.
     *  In contrary to that it MUST contain a CashRegister Id. Used as the default type for operations
     *  within the *-POS Cases, where the Actions are performed by specific CashRegisters
     */
    protected MerchantInformationType $MerchantInformation;

    protected OrderType $Order;

    /**
     * @var 'NO_PAIRING' | 'PAIRING_IN_PROGRESS' | 'PAIRING_ACTIVE'
     */
    protected string $PairingStatus;

    /**
     * Base type: restriction of xs:string Pattern: [A-Fa-f0-9]{32}|(\{|\()?[A-Fa-f0-9]{8}-([A-Fa-f0-9]{4}-){3}[A-Fa-f0-9]{12}(\}|\))? This type is used by other XML schema attributes or elements that will
     *  hold a universal unique identifier (UUID), commonly known as either a globally unique identifier (GUID) or UUID. The regular expression defined limits the contents of an attribute to either a
     *  single 32-digit hexadecimal string or a 32-digit hex string patterned as [8]-[4]-[4]-[4]-[12] digits.
     */
    protected ?string $CustomerRelationUuid = null;

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

    public function getOrder(): OrderType
    {
        return $this->Order;
    }

    public function withOrder(OrderType $Order): static
    {
        $new = clone $this;
        $new->Order = $Order;

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
}
