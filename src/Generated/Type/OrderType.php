<?php

namespace Twint\Sdk\Generated\Type;

class OrderType
{
    /**
     * @var string
     */
    private $Uuid;

    /**
     * @var \Twint\Sdk\Generated\Type\OrderStatusType
     */
    private $Status;

    /**
     * @var \DateTimeInterface
     */
    private $CreationTimestamp;

    /**
     * @var \Twint\Sdk\Generated\Type\CurrencyAmountType
     */
    private $AuthorizedAmount;

    /**
     * @var \Twint\Sdk\Generated\Type\CurrencyAmountType
     */
    private $Fee;

    /**
     * @var \DateTimeInterface
     */
    private $ProcessingTimestamp;

    /**
     * @var \Twint\Sdk\Generated\Type\PaymentAmountType
     */
    private $PaymentAmount;

    /**
     * @var \Twint\Sdk\Generated\Type\BNPLDataType
     */
    private $BNPLData;

    /**
     * @return string
     */
    public function getUuid()
    {
        return $this->Uuid;
    }

    /**
     * @param string $Uuid
     * @return OrderType
     */
    public function withUuid($Uuid)
    {
        $new = clone $this;
        $new->Uuid = $Uuid;

        return $new;
    }

    /**
     * @return \Twint\Sdk\Generated\Type\OrderStatusType
     */
    public function getStatus()
    {
        return $this->Status;
    }

    /**
     * @param \Twint\Sdk\Generated\Type\OrderStatusType $Status
     * @return OrderType
     */
    public function withStatus($Status)
    {
        $new = clone $this;
        $new->Status = $Status;

        return $new;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getCreationTimestamp()
    {
        return $this->CreationTimestamp;
    }

    /**
     * @param \DateTimeInterface $CreationTimestamp
     * @return OrderType
     */
    public function withCreationTimestamp($CreationTimestamp)
    {
        $new = clone $this;
        $new->CreationTimestamp = $CreationTimestamp;

        return $new;
    }

    /**
     * @return \Twint\Sdk\Generated\Type\CurrencyAmountType
     */
    public function getAuthorizedAmount()
    {
        return $this->AuthorizedAmount;
    }

    /**
     * @param \Twint\Sdk\Generated\Type\CurrencyAmountType $AuthorizedAmount
     * @return OrderType
     */
    public function withAuthorizedAmount($AuthorizedAmount)
    {
        $new = clone $this;
        $new->AuthorizedAmount = $AuthorizedAmount;

        return $new;
    }

    /**
     * @return \Twint\Sdk\Generated\Type\CurrencyAmountType
     */
    public function getFee()
    {
        return $this->Fee;
    }

    /**
     * @param \Twint\Sdk\Generated\Type\CurrencyAmountType $Fee
     * @return OrderType
     */
    public function withFee($Fee)
    {
        $new = clone $this;
        $new->Fee = $Fee;

        return $new;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getProcessingTimestamp()
    {
        return $this->ProcessingTimestamp;
    }

    /**
     * @param \DateTimeInterface $ProcessingTimestamp
     * @return OrderType
     */
    public function withProcessingTimestamp($ProcessingTimestamp)
    {
        $new = clone $this;
        $new->ProcessingTimestamp = $ProcessingTimestamp;

        return $new;
    }

    /**
     * @return \Twint\Sdk\Generated\Type\PaymentAmountType
     */
    public function getPaymentAmount()
    {
        return $this->PaymentAmount;
    }

    /**
     * @param \Twint\Sdk\Generated\Type\PaymentAmountType $PaymentAmount
     * @return OrderType
     */
    public function withPaymentAmount($PaymentAmount)
    {
        $new = clone $this;
        $new->PaymentAmount = $PaymentAmount;

        return $new;
    }

    /**
     * @return \Twint\Sdk\Generated\Type\BNPLDataType
     */
    public function getBNPLData()
    {
        return $this->BNPLData;
    }

    /**
     * @param \Twint\Sdk\Generated\Type\BNPLDataType $BNPLData
     * @return OrderType
     */
    public function withBNPLData($BNPLData)
    {
        $new = clone $this;
        $new->BNPLData = $BNPLData;

        return $new;
    }
}

