<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

class RegistrationType
{
    /**
     * @var 'PENDING' | 'NEEDS_CONFIRMATION' | 'SUCCESS' | 'ERROR' | 'CANCELED'
     */
    protected string $RegistrationStatus;

    /**
     * Base type: restriction of xs:string Pattern: [A-Fa-f0-9]{32}|(\{|\()?[A-Fa-f0-9]{8}-([A-Fa-f0-9]{4}-){3}[A-Fa-f0-9]{12}(\}|\))? This type is used by other XML schema attributes or elements that will
     *  hold a universal unique identifier (UUID), commonly known as either a globally unique identifier (GUID) or UUID. The regular expression defined limits the contents of an attribute to either a
     *  single 32-digit hexadecimal string or a 32-digit hex string patterned as [8]-[4]-[4]-[4]-[12] digits.
     */
    protected ?string $UofCustomerRelationUuid;

    /**
     * @var null | mixed
     */
    protected mixed $ConfirmedMerchantCredential;

    /**
     * @return 'PENDING' | 'NEEDS_CONFIRMATION' | 'SUCCESS' | 'ERROR' | 'CANCELED'
     */
    public function getRegistrationStatus(): string
    {
        return $this->RegistrationStatus;
    }

    /**
     * @param 'PENDING' | 'NEEDS_CONFIRMATION' | 'SUCCESS' | 'ERROR' | 'CANCELED' $RegistrationStatus
     */
    public function withRegistrationStatus(string $RegistrationStatus): static
    {
        $new = clone $this;
        $new->RegistrationStatus = $RegistrationStatus;

        return $new;
    }

    public function getUofCustomerRelationUuid(): ?string
    {
        return $this->UofCustomerRelationUuid;
    }

    public function withUofCustomerRelationUuid(?string $UofCustomerRelationUuid): static
    {
        $new = clone $this;
        $new->UofCustomerRelationUuid = $UofCustomerRelationUuid;

        return $new;
    }

    /**
     * @return null | mixed
     */
    public function getConfirmedMerchantCredential(): mixed
    {
        return $this->ConfirmedMerchantCredential;
    }

    /**
     * @param null | mixed $ConfirmedMerchantCredential
     */
    public function withConfirmedMerchantCredential(mixed $ConfirmedMerchantCredential): static
    {
        $new = clone $this;
        $new->ConfirmedMerchantCredential = $ConfirmedMerchantCredential;

        return $new;
    }
}
