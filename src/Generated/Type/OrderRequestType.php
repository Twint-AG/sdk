<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

class OrderRequestType
{
    /**
     * @var 'GOODS' | 'MONEY'
     */
    protected string $PostingType;

    protected CurrencyAmountType $RequestedAmount;

    /**
     * Reference number by which the merchant might want to identify
     *  this voucher in his own applications.
     */
    protected ?string $MerchantTransactionReference;

    protected ?CurrencyAmountType $CustomerBenefit;

    protected ?string $EReceiptUrl;

    protected ?OrderLinkType $Link;

    protected ?string $OrderDetailsUrl;

    /**
     * Basic structure of the description of a time based service.
     *  MUST contain a message type identifier, start and an end time stamp.
     */
    protected ?TimeBasedDataType $TimeBasedData;

    /**
     * Enumeration based on xs:string, defines the payment authorization type for an order.
     *  - FINAL_AUTH: Authorization of the final amount, standard case
     *  - PRE_AUTH: PreAuthorization of a defined maximum amount, which will be reserved on the customer account.
     *  The final amount will be requested later with the confirmation
     *
     * @var null | 'FINAL_AUTH' | 'PRE_AUTH'
     */
    protected ?string $PaymentAuthorizationType;

    /**
     * ConfirmationButtonType is used to allow merchants to customise the labels for the confirmation button.
     */
    protected ?string $ConfirmationButtonId;

    /**
     * @var 'PAYMENT_IMMEDIATE' | 'PAYMENT_DEFERRED' | 'PAYMENT_RECURRING' | 'REVERSAL' | 'CREDIT'
     */
    protected string $type;

    protected ?bool $confirmationNeeded;

    /**
     * @return 'GOODS' | 'MONEY'
     */
    public function getPostingType(): string
    {
        return $this->PostingType;
    }

    /**
     * @param 'GOODS' | 'MONEY' $PostingType
     */
    public function withPostingType(string $PostingType): static
    {
        $new = clone $this;
        $new->PostingType = $PostingType;

        return $new;
    }

    public function getRequestedAmount(): CurrencyAmountType
    {
        return $this->RequestedAmount;
    }

    public function withRequestedAmount(CurrencyAmountType $RequestedAmount): static
    {
        $new = clone $this;
        $new->RequestedAmount = $RequestedAmount;

        return $new;
    }

    public function getMerchantTransactionReference(): ?string
    {
        return $this->MerchantTransactionReference;
    }

    public function withMerchantTransactionReference(?string $MerchantTransactionReference): static
    {
        $new = clone $this;
        $new->MerchantTransactionReference = $MerchantTransactionReference;

        return $new;
    }

    public function getCustomerBenefit(): ?CurrencyAmountType
    {
        return $this->CustomerBenefit;
    }

    public function withCustomerBenefit(?CurrencyAmountType $CustomerBenefit): static
    {
        $new = clone $this;
        $new->CustomerBenefit = $CustomerBenefit;

        return $new;
    }

    public function getEReceiptUrl(): ?string
    {
        return $this->EReceiptUrl;
    }

    public function withEReceiptUrl(?string $EReceiptUrl): static
    {
        $new = clone $this;
        $new->EReceiptUrl = $EReceiptUrl;

        return $new;
    }

    public function getLink(): ?OrderLinkType
    {
        return $this->Link;
    }

    public function withLink(?OrderLinkType $Link): static
    {
        $new = clone $this;
        $new->Link = $Link;

        return $new;
    }

    public function getOrderDetailsUrl(): ?string
    {
        return $this->OrderDetailsUrl;
    }

    public function withOrderDetailsUrl(?string $OrderDetailsUrl): static
    {
        $new = clone $this;
        $new->OrderDetailsUrl = $OrderDetailsUrl;

        return $new;
    }

    public function getTimeBasedData(): ?TimeBasedDataType
    {
        return $this->TimeBasedData;
    }

    public function withTimeBasedData(?TimeBasedDataType $TimeBasedData): static
    {
        $new = clone $this;
        $new->TimeBasedData = $TimeBasedData;

        return $new;
    }

    /**
     * @return null | 'FINAL_AUTH' | 'PRE_AUTH'
     */
    public function getPaymentAuthorizationType(): ?string
    {
        return $this->PaymentAuthorizationType;
    }

    /**
     * @param null | 'FINAL_AUTH' | 'PRE_AUTH' $PaymentAuthorizationType
     */
    public function withPaymentAuthorizationType(?string $PaymentAuthorizationType): static
    {
        $new = clone $this;
        $new->PaymentAuthorizationType = $PaymentAuthorizationType;

        return $new;
    }

    public function getConfirmationButtonId(): ?string
    {
        return $this->ConfirmationButtonId;
    }

    public function withConfirmationButtonId(?string $ConfirmationButtonId): static
    {
        $new = clone $this;
        $new->ConfirmationButtonId = $ConfirmationButtonId;

        return $new;
    }

    /**
     * @return 'PAYMENT_IMMEDIATE' | 'PAYMENT_DEFERRED' | 'PAYMENT_RECURRING' | 'REVERSAL' | 'CREDIT'
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param 'PAYMENT_IMMEDIATE' | 'PAYMENT_DEFERRED' | 'PAYMENT_RECURRING' | 'REVERSAL' | 'CREDIT' $type
     */
    public function withType(string $type): static
    {
        $new = clone $this;
        $new->type = $type;

        return $new;
    }

    public function getConfirmationNeeded(): ?bool
    {
        return $this->confirmationNeeded;
    }

    public function withConfirmationNeeded(?bool $confirmationNeeded): static
    {
        $new = clone $this;
        $new->confirmationNeeded = $confirmationNeeded;

        return $new;
    }
}
