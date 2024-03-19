<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use AllowDynamicProperties;
use DateTimeInterface;

#[AllowDynamicProperties]
final class OrderType
{
    /**
     * @var string
     */
    private $Uuid;

    /**
     * @var OrderStatusType
     */
    private $Status;

    /**
     * @var DateTimeInterface
     */
    private $CreationTimestamp;

    /**
     * @var CurrencyAmountType
     */
    private $AuthorizedAmount;

    /**
     * @var CurrencyAmountType
     */
    private $Fee;

    /**
     * @var DateTimeInterface
     */
    private $ProcessingTimestamp;

    /**
     * @var PaymentAmountType
     */
    private $PaymentAmount;

    /**
     * @var BNPLDataType
     */
    private $BNPLData;

    /**
     * @var string
     */
    private $MerchantTransactionReference;

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
     * @return OrderStatusType
     */
    public function getStatus()
    {
        return $this->Status;
    }

    /**
     * @param OrderStatusType $Status
     * @return OrderType
     */
    public function withStatus($Status)
    {
        $new = clone $this;
        $new->Status = $Status;

        return $new;
    }

    /**
     * @return DateTimeInterface
     */
    public function getCreationTimestamp()
    {
        return $this->CreationTimestamp;
    }

    /**
     * @param DateTimeInterface $CreationTimestamp
     * @return OrderType
     */
    public function withCreationTimestamp($CreationTimestamp)
    {
        $new = clone $this;
        $new->CreationTimestamp = $CreationTimestamp;

        return $new;
    }

    /**
     * @return CurrencyAmountType
     */
    public function getAuthorizedAmount()
    {
        return $this->AuthorizedAmount;
    }

    /**
     * @param CurrencyAmountType $AuthorizedAmount
     * @return OrderType
     */
    public function withAuthorizedAmount($AuthorizedAmount)
    {
        $new = clone $this;
        $new->AuthorizedAmount = $AuthorizedAmount;

        return $new;
    }

    /**
     * @return CurrencyAmountType
     */
    public function getFee()
    {
        return $this->Fee;
    }

    /**
     * @param CurrencyAmountType $Fee
     * @return OrderType
     */
    public function withFee($Fee)
    {
        $new = clone $this;
        $new->Fee = $Fee;

        return $new;
    }

    /**
     * @return DateTimeInterface
     */
    public function getProcessingTimestamp()
    {
        return $this->ProcessingTimestamp;
    }

    /**
     * @param DateTimeInterface $ProcessingTimestamp
     * @return OrderType
     */
    public function withProcessingTimestamp($ProcessingTimestamp)
    {
        $new = clone $this;
        $new->ProcessingTimestamp = $ProcessingTimestamp;

        return $new;
    }

    /**
     * @return PaymentAmountType
     */
    public function getPaymentAmount()
    {
        return $this->PaymentAmount;
    }

    /**
     * @param PaymentAmountType $PaymentAmount
     * @return OrderType
     */
    public function withPaymentAmount($PaymentAmount)
    {
        $new = clone $this;
        $new->PaymentAmount = $PaymentAmount;

        return $new;
    }

    /**
     * @return BNPLDataType
     */
    public function getBNPLData()
    {
        return $this->BNPLData;
    }

    /**
     * @param BNPLDataType $BNPLData
     * @return OrderType
     */
    public function withBNPLData($BNPLData)
    {
        $new = clone $this;
        $new->BNPLData = $BNPLData;

        return $new;
    }

    /**
     * @return string
     */
    public function getMerchantTransactionReference()
    {
        return $this->MerchantTransactionReference;
    }

    /**
     * @param string $MerchantTransactionReference
     * @return OrderType
     */
    public function withMerchantTransactionReference($MerchantTransactionReference)
    {
        $new = clone $this;
        $new->MerchantTransactionReference = $MerchantTransactionReference;

        return $new;
    }
}
