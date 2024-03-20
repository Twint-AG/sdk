<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use DateTimeInterface;

final class OrderType
{
    /**
     * @var string
     */
    private $PostingType;

    /**
     * @var CurrencyAmountType
     */
    private $RequestedAmount;

    /**
     * @var string
     */
    private $MerchantTransactionReference;

    /**
     * @var CurrencyAmountType
     */
    private $CustomerBenefit;

    /**
     * @var string
     */
    private $EReceiptUrl;

    /**
     * @var OrderLinkType
     */
    private $Link;

    /**
     * @var string
     */
    private $OrderDetailsUrl;

    /**
     * @var TimeBasedDataType
     */
    private $TimeBasedData;

    /**
     * @var string
     */
    private $PaymentAuthorizationType;

    /**
     * @var string
     */
    private $ConfirmationButtonId;

    /**
     * @var string
     */
    private $type;

    /**
     * @var bool
     */
    private $confirmationNeeded;

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
     * @return string
     */
    public function getPostingType()
    {
        return $this->PostingType;
    }

    public function withPostingType(string $PostingType): self
    {
        $new = clone $this;
        $new->PostingType = $PostingType;

        return $new;
    }

    /**
     * @return CurrencyAmountType
     */
    public function getRequestedAmount()
    {
        return $this->RequestedAmount;
    }

    public function withRequestedAmount(CurrencyAmountType $RequestedAmount): self
    {
        $new = clone $this;
        $new->RequestedAmount = $RequestedAmount;

        return $new;
    }

    /**
     * @return CurrencyAmountType
     */
    public function getCustomerBenefit()
    {
        return $this->CustomerBenefit;
    }

    public function withCustomerBenefit(CurrencyAmountType $CustomerBenefit): self
    {
        $new = clone $this;
        $new->CustomerBenefit = $CustomerBenefit;

        return $new;
    }

    /**
     * @return string
     */
    public function getEReceiptUrl()
    {
        return $this->EReceiptUrl;
    }

    public function withEReceiptUrl(string $EReceiptUrl): self
    {
        $new = clone $this;
        $new->EReceiptUrl = $EReceiptUrl;

        return $new;
    }

    /**
     * @return OrderLinkType
     */
    public function getLink()
    {
        return $this->Link;
    }

    public function withLink(OrderLinkType $Link): self
    {
        $new = clone $this;
        $new->Link = $Link;

        return $new;
    }

    /**
     * @return string
     */
    public function getOrderDetailsUrl()
    {
        return $this->OrderDetailsUrl;
    }

    public function withOrderDetailsUrl(string $OrderDetailsUrl): self
    {
        $new = clone $this;
        $new->OrderDetailsUrl = $OrderDetailsUrl;

        return $new;
    }

    /**
     * @return TimeBasedDataType
     */
    public function getTimeBasedData()
    {
        return $this->TimeBasedData;
    }

    public function withTimeBasedData(TimeBasedDataType $TimeBasedData): self
    {
        $new = clone $this;
        $new->TimeBasedData = $TimeBasedData;

        return $new;
    }

    /**
     * @return string
     */
    public function getPaymentAuthorizationType()
    {
        return $this->PaymentAuthorizationType;
    }

    public function withPaymentAuthorizationType(string $PaymentAuthorizationType): self
    {
        $new = clone $this;
        $new->PaymentAuthorizationType = $PaymentAuthorizationType;

        return $new;
    }

    /**
     * @return string
     */
    public function getConfirmationButtonId()
    {
        return $this->ConfirmationButtonId;
    }

    public function withConfirmationButtonId(string $ConfirmationButtonId): self
    {
        $new = clone $this;
        $new->ConfirmationButtonId = $ConfirmationButtonId;

        return $new;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    public function withType(string $type): self
    {
        $new = clone $this;
        $new->type = $type;

        return $new;
    }

    /**
     * @return bool
     */
    public function getConfirmationNeeded()
    {
        return $this->confirmationNeeded;
    }

    public function withConfirmationNeeded(bool $confirmationNeeded): self
    {
        $new = clone $this;
        $new->confirmationNeeded = $confirmationNeeded;

        return $new;
    }

    /**
     * @return string
     */
    public function getUuid()
    {
        return $this->Uuid;
    }

    public function withUuid(string $Uuid): self
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

    public function withStatus(OrderStatusType $Status): self
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

    public function withCreationTimestamp(DateTimeInterface $CreationTimestamp): self
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

    public function withAuthorizedAmount(CurrencyAmountType $AuthorizedAmount): self
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

    public function withFee(CurrencyAmountType $Fee): self
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

    public function withProcessingTimestamp(DateTimeInterface $ProcessingTimestamp): self
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

    public function withPaymentAmount(PaymentAmountType $PaymentAmount): self
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

    public function withBNPLData(BNPLDataType $BNPLData): self
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

    public function withMerchantTransactionReference(string $MerchantTransactionReference): self
    {
        $new = clone $this;
        $new->MerchantTransactionReference = $MerchantTransactionReference;

        return $new;
    }
}
