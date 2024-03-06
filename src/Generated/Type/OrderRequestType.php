<?php

namespace Twint\Sdk\Generated\Type;

class OrderRequestType
{
    /**
     * @var string
     */
    private $PostingType;

    /**
     * @var \Twint\Sdk\Generated\Type\CurrencyAmountType
     */
    private $RequestedAmount;

    /**
     * @var string
     */
    private $MerchantTransactionReference;

    /**
     * @var \Twint\Sdk\Generated\Type\CurrencyAmountType
     */
    private $CustomerBenefit;

    /**
     * @var string
     */
    private $EReceiptUrl;

    /**
     * @var \Twint\Sdk\Generated\Type\OrderLinkType
     */
    private $Link;

    /**
     * @var string
     */
    private $OrderDetailsUrl;

    /**
     * @var \Twint\Sdk\Generated\Type\TimeBasedDataType
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
     * @return string
     */
    public function getPostingType()
    {
        return $this->PostingType;
    }

    /**
     * @param string $PostingType
     * @return OrderRequestType
     */
    public function withPostingType($PostingType)
    {
        $new = clone $this;
        $new->PostingType = $PostingType;

        return $new;
    }

    /**
     * @return \Twint\Sdk\Generated\Type\CurrencyAmountType
     */
    public function getRequestedAmount()
    {
        return $this->RequestedAmount;
    }

    /**
     * @param \Twint\Sdk\Generated\Type\CurrencyAmountType $RequestedAmount
     * @return OrderRequestType
     */
    public function withRequestedAmount($RequestedAmount)
    {
        $new = clone $this;
        $new->RequestedAmount = $RequestedAmount;

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
     * @return OrderRequestType
     */
    public function withMerchantTransactionReference($MerchantTransactionReference)
    {
        $new = clone $this;
        $new->MerchantTransactionReference = $MerchantTransactionReference;

        return $new;
    }

    /**
     * @return \Twint\Sdk\Generated\Type\CurrencyAmountType
     */
    public function getCustomerBenefit()
    {
        return $this->CustomerBenefit;
    }

    /**
     * @param \Twint\Sdk\Generated\Type\CurrencyAmountType $CustomerBenefit
     * @return OrderRequestType
     */
    public function withCustomerBenefit($CustomerBenefit)
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

    /**
     * @param string $EReceiptUrl
     * @return OrderRequestType
     */
    public function withEReceiptUrl($EReceiptUrl)
    {
        $new = clone $this;
        $new->EReceiptUrl = $EReceiptUrl;

        return $new;
    }

    /**
     * @return \Twint\Sdk\Generated\Type\OrderLinkType
     */
    public function getLink()
    {
        return $this->Link;
    }

    /**
     * @param \Twint\Sdk\Generated\Type\OrderLinkType $Link
     * @return OrderRequestType
     */
    public function withLink($Link)
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

    /**
     * @param string $OrderDetailsUrl
     * @return OrderRequestType
     */
    public function withOrderDetailsUrl($OrderDetailsUrl)
    {
        $new = clone $this;
        $new->OrderDetailsUrl = $OrderDetailsUrl;

        return $new;
    }

    /**
     * @return \Twint\Sdk\Generated\Type\TimeBasedDataType
     */
    public function getTimeBasedData()
    {
        return $this->TimeBasedData;
    }

    /**
     * @param \Twint\Sdk\Generated\Type\TimeBasedDataType $TimeBasedData
     * @return OrderRequestType
     */
    public function withTimeBasedData($TimeBasedData)
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

    /**
     * @param string $PaymentAuthorizationType
     * @return OrderRequestType
     */
    public function withPaymentAuthorizationType($PaymentAuthorizationType)
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

    /**
     * @param string $ConfirmationButtonId
     * @return OrderRequestType
     */
    public function withConfirmationButtonId($ConfirmationButtonId)
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

    /**
     * @param string $type
     * @return OrderRequestType
     */
    public function withType($type)
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

    /**
     * @param bool $confirmationNeeded
     * @return OrderRequestType
     */
    public function withConfirmationNeeded($confirmationNeeded)
    {
        $new = clone $this;
        $new->confirmationNeeded = $confirmationNeeded;

        return $new;
    }
}

