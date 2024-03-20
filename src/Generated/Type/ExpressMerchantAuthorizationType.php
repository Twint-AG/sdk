<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

final class ExpressMerchantAuthorizationType
{
    /**
     * @var string
     */
    private $TerminalId;

    /**
     * @var string
     */
    private $SequenceCounter;

    /**
     * @var string
     */
    private $CustomerUuid;

    /**
     * @var string
     */
    private $Operation;

    /**
     * @var string
     */
    private $ReservationTimestamp;

    /**
     * @var string
     */
    private $OrderUuid;

    /**
     * @var string
     */
    private $RequestSignature;

    /**
     * @var string
     */
    private $RequestKey;

    /**
     * @var string
     */
    private $UofPaymentType;

    /**
     * @return string
     */
    public function getTerminalId()
    {
        return $this->TerminalId;
    }

    public function withTerminalId(string $TerminalId): self
    {
        $new = clone $this;
        $new->TerminalId = $TerminalId;

        return $new;
    }

    /**
     * @return string
     */
    public function getSequenceCounter()
    {
        return $this->SequenceCounter;
    }

    public function withSequenceCounter(string $SequenceCounter): self
    {
        $new = clone $this;
        $new->SequenceCounter = $SequenceCounter;

        return $new;
    }

    /**
     * @return string
     */
    public function getCustomerUuid()
    {
        return $this->CustomerUuid;
    }

    public function withCustomerUuid(string $CustomerUuid): self
    {
        $new = clone $this;
        $new->CustomerUuid = $CustomerUuid;

        return $new;
    }

    /**
     * @return string
     */
    public function getOperation()
    {
        return $this->Operation;
    }

    public function withOperation(string $Operation): self
    {
        $new = clone $this;
        $new->Operation = $Operation;

        return $new;
    }

    /**
     * @return string
     */
    public function getReservationTimestamp()
    {
        return $this->ReservationTimestamp;
    }

    public function withReservationTimestamp(string $ReservationTimestamp): self
    {
        $new = clone $this;
        $new->ReservationTimestamp = $ReservationTimestamp;

        return $new;
    }

    /**
     * @return string
     */
    public function getOrderUuid()
    {
        return $this->OrderUuid;
    }

    public function withOrderUuid(string $OrderUuid): self
    {
        $new = clone $this;
        $new->OrderUuid = $OrderUuid;

        return $new;
    }

    /**
     * @return string
     */
    public function getRequestSignature()
    {
        return $this->RequestSignature;
    }

    public function withRequestSignature(string $RequestSignature): self
    {
        $new = clone $this;
        $new->RequestSignature = $RequestSignature;

        return $new;
    }

    /**
     * @return string
     */
    public function getRequestKey()
    {
        return $this->RequestKey;
    }

    public function withRequestKey(string $RequestKey): self
    {
        $new = clone $this;
        $new->RequestKey = $RequestKey;

        return $new;
    }

    /**
     * @return string
     */
    public function getUofPaymentType()
    {
        return $this->UofPaymentType;
    }

    public function withUofPaymentType(string $UofPaymentType): self
    {
        $new = clone $this;
        $new->UofPaymentType = $UofPaymentType;

        return $new;
    }
}
