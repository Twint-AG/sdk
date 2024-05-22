<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

class ExpressMerchantAuthorizationType
{
    protected ?string $TerminalId = null;

    protected ?string $SequenceCounter = null;

    /**
     * Base type: restriction of xs:string Pattern: [A-Fa-f0-9]{32}|(\{|\()?[A-Fa-f0-9]{8}-([A-Fa-f0-9]{4}-){3}[A-Fa-f0-9]{12}(\}|\))? This type is used by other XML schema attributes or elements that will
     *  hold a universal unique identifier (UUID), commonly known as either a globally unique identifier (GUID) or UUID. The regular expression defined limits the contents of an attribute to either a
     *  single 32-digit hexadecimal string or a 32-digit hex string patterned as [8]-[4]-[4]-[4]-[12] digits.
     */
    protected string $CustomerUuid;

    protected string $Operation;

    protected string $ReservationTimestamp;

    /**
     * Base type: restriction of xs:string Pattern: [A-Fa-f0-9]{32}|(\{|\()?[A-Fa-f0-9]{8}-([A-Fa-f0-9]{4}-){3}[A-Fa-f0-9]{12}(\}|\))? This type is used by other XML schema attributes or elements that will
     *  hold a universal unique identifier (UUID), commonly known as either a globally unique identifier (GUID) or UUID. The regular expression defined limits the contents of an attribute to either a
     *  single 32-digit hexadecimal string or a 32-digit hex string patterned as [8]-[4]-[4]-[4]-[12] digits.
     */
    protected string $OrderUuid;

    protected mixed $RequestSignature;

    protected mixed $RequestKey;

    /**
     * @var null | 'CUSTOMER_INITIATED' | 'RECURRING' | 'UNSCHEDULED' | 'INSTALLMENT'
     */
    protected ?string $UofPaymentType = null;

    public function getTerminalId(): ?string
    {
        return $this->TerminalId;
    }

    public function withTerminalId(?string $TerminalId): static
    {
        $new = clone $this;
        $new->TerminalId = $TerminalId;

        return $new;
    }

    public function getSequenceCounter(): ?string
    {
        return $this->SequenceCounter;
    }

    public function withSequenceCounter(?string $SequenceCounter): static
    {
        $new = clone $this;
        $new->SequenceCounter = $SequenceCounter;

        return $new;
    }

    public function getCustomerUuid(): string
    {
        return $this->CustomerUuid;
    }

    public function withCustomerUuid(string $CustomerUuid): static
    {
        $new = clone $this;
        $new->CustomerUuid = $CustomerUuid;

        return $new;
    }

    public function getOperation(): string
    {
        return $this->Operation;
    }

    public function withOperation(string $Operation): static
    {
        $new = clone $this;
        $new->Operation = $Operation;

        return $new;
    }

    public function getReservationTimestamp(): string
    {
        return $this->ReservationTimestamp;
    }

    public function withReservationTimestamp(string $ReservationTimestamp): static
    {
        $new = clone $this;
        $new->ReservationTimestamp = $ReservationTimestamp;

        return $new;
    }

    public function getOrderUuid(): string
    {
        return $this->OrderUuid;
    }

    public function withOrderUuid(string $OrderUuid): static
    {
        $new = clone $this;
        $new->OrderUuid = $OrderUuid;

        return $new;
    }

    public function getRequestSignature(): mixed
    {
        return $this->RequestSignature;
    }

    public function withRequestSignature(mixed $RequestSignature): static
    {
        $new = clone $this;
        $new->RequestSignature = $RequestSignature;

        return $new;
    }

    public function getRequestKey(): mixed
    {
        return $this->RequestKey;
    }

    public function withRequestKey(mixed $RequestKey): static
    {
        $new = clone $this;
        $new->RequestKey = $RequestKey;

        return $new;
    }

    /**
     * @return null | 'CUSTOMER_INITIATED' | 'RECURRING' | 'UNSCHEDULED' | 'INSTALLMENT'
     */
    public function getUofPaymentType(): ?string
    {
        return $this->UofPaymentType;
    }

    /**
     * @param null | 'CUSTOMER_INITIATED' | 'RECURRING' | 'UNSCHEDULED' | 'INSTALLMENT' $UofPaymentType
     */
    public function withUofPaymentType(?string $UofPaymentType): static
    {
        $new = clone $this;
        $new->UofPaymentType = $UofPaymentType;

        return $new;
    }
}
