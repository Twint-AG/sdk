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

    /**
     * @param string $TerminalId
     * @return ExpressMerchantAuthorizationType
     */
    public function withTerminalId($TerminalId)
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

    /**
     * @param string $SequenceCounter
     * @return ExpressMerchantAuthorizationType
     */
    public function withSequenceCounter($SequenceCounter)
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

    /**
     * @param string $CustomerUuid
     * @return ExpressMerchantAuthorizationType
     */
    public function withCustomerUuid($CustomerUuid)
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

    /**
     * @param string $Operation
     * @return ExpressMerchantAuthorizationType
     */
    public function withOperation($Operation)
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

    /**
     * @param string $ReservationTimestamp
     * @return ExpressMerchantAuthorizationType
     */
    public function withReservationTimestamp($ReservationTimestamp)
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

    /**
     * @param string $OrderUuid
     * @return ExpressMerchantAuthorizationType
     */
    public function withOrderUuid($OrderUuid)
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

    /**
     * @param string $RequestSignature
     * @return ExpressMerchantAuthorizationType
     */
    public function withRequestSignature($RequestSignature)
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

    /**
     * @param string $RequestKey
     * @return ExpressMerchantAuthorizationType
     */
    public function withRequestKey($RequestKey)
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

    /**
     * @param string $UofPaymentType
     * @return ExpressMerchantAuthorizationType
     */
    public function withUofPaymentType($UofPaymentType)
    {
        $new = clone $this;
        $new->UofPaymentType = $UofPaymentType;

        return $new;
    }
}
