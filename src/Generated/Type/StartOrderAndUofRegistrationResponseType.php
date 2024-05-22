<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use Phpro\SoapClient\Type\ResultInterface;

class StartOrderAndUofRegistrationResponseType implements ResultInterface
{
    protected ?TWINTTokenType $Token = null;

    protected ?string $TwintURL = null;

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

    protected OrderStatusType $PaymentOrderStatus;

    /**
     * Base type: restriction of xs:string Pattern: [A-Fa-f0-9]{32}|(\{|\()?[A-Fa-f0-9]{8}-([A-Fa-f0-9]{4}-){3}[A-Fa-f0-9]{12}(\}|\))? This type is used by other XML schema attributes or elements that will
     *  hold a universal unique identifier (UUID), commonly known as either a globally unique identifier (GUID) or UUID. The regular expression defined limits the contents of an attribute to either a
     *  single 32-digit hexadecimal string or a 32-digit hex string patterned as [8]-[4]-[4]-[4]-[12] digits.
     */
    protected string $RegistrationUuid;

    /**
     * @var 'PENDING' | 'NEEDS_CONFIRMATION' | 'SUCCESS' | 'ERROR' | 'CANCELED'
     */
    protected string $RegistrationStatus;

    public function getToken(): ?TWINTTokenType
    {
        return $this->Token;
    }

    public function withToken(?TWINTTokenType $Token): static
    {
        $new = clone $this;
        $new->Token = $Token;

        return $new;
    }

    public function getTwintURL(): ?string
    {
        return $this->TwintURL;
    }

    public function withTwintURL(?string $TwintURL): static
    {
        $new = clone $this;
        $new->TwintURL = $TwintURL;

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

    public function getPaymentOrderStatus(): OrderStatusType
    {
        return $this->PaymentOrderStatus;
    }

    public function withPaymentOrderStatus(OrderStatusType $PaymentOrderStatus): static
    {
        $new = clone $this;
        $new->PaymentOrderStatus = $PaymentOrderStatus;

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
}
