<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use DateTimeInterface;

class OrderType extends OrderRequestType
{
    /**
     * Base type: restriction of xs:string Pattern: [A-Fa-f0-9]{32}|(\{|\()?[A-Fa-f0-9]{8}-([A-Fa-f0-9]{4}-){3}[A-Fa-f0-9]{12}(\}|\))? This type is used by other XML schema attributes or elements that will
     *  hold a universal unique identifier (UUID), commonly known as either a globally unique identifier (GUID) or UUID. The regular expression defined limits the contents of an attribute to either a
     *  single 32-digit hexadecimal string or a 32-digit hex string patterned as [8]-[4]-[4]-[4]-[12] digits.
     */
    protected string $Uuid;

    protected OrderStatusType $Status;

    protected DateTimeInterface $CreationTimestamp;

    protected ?CurrencyAmountType $AuthorizedAmount;

    protected ?CurrencyAmountType $Fee;

    protected ?DateTimeInterface $ProcessingTimestamp;

    /**
     * @var array<int<1,max>, \Twint\Sdk\Generated\Type\PaymentAmountType>
     */
    protected array $PaymentAmount;

    /**
     * Optional data structure to provide the BNPL (\"buy now pay later\") related data to the Payment Service
     *  Provider (PSP).
     *  The structure contains the required fields to create awareness of a BNPL payments.
     *  This data is only contained in the payload for BNPL payments.
     *  Note: For BNPL Payments the Fee-Element contains a blended fee of merchant's payment fee plus the BNPL
     *  markup.
     */
    protected ?BNPLDataType $BNPLData;

    /**
     * Reference number by which the merchant might want to identify
     *  this voucher in his own applications.
     */
    protected ?string $MerchantTransactionReference;

    public function getUuid(): string
    {
        return $this->Uuid;
    }

    public function withUuid(string $Uuid): static
    {
        $new = clone $this;
        $new->Uuid = $Uuid;

        return $new;
    }

    public function getStatus(): OrderStatusType
    {
        return $this->Status;
    }

    public function withStatus(OrderStatusType $Status): static
    {
        $new = clone $this;
        $new->Status = $Status;

        return $new;
    }

    public function getCreationTimestamp(): DateTimeInterface
    {
        return $this->CreationTimestamp;
    }

    public function withCreationTimestamp(DateTimeInterface $CreationTimestamp): static
    {
        $new = clone $this;
        $new->CreationTimestamp = $CreationTimestamp;

        return $new;
    }

    public function getAuthorizedAmount(): ?CurrencyAmountType
    {
        return $this->AuthorizedAmount;
    }

    public function withAuthorizedAmount(?CurrencyAmountType $AuthorizedAmount): static
    {
        $new = clone $this;
        $new->AuthorizedAmount = $AuthorizedAmount;

        return $new;
    }

    public function getFee(): ?CurrencyAmountType
    {
        return $this->Fee;
    }

    public function withFee(?CurrencyAmountType $Fee): static
    {
        $new = clone $this;
        $new->Fee = $Fee;

        return $new;
    }

    public function getProcessingTimestamp(): ?DateTimeInterface
    {
        return $this->ProcessingTimestamp;
    }

    public function withProcessingTimestamp(?DateTimeInterface $ProcessingTimestamp): static
    {
        $new = clone $this;
        $new->ProcessingTimestamp = $ProcessingTimestamp;

        return $new;
    }

    /**
     * @return array<int<1,max>, \Twint\Sdk\Generated\Type\PaymentAmountType>
     */
    public function getPaymentAmount(): array
    {
        return $this->PaymentAmount;
    }

    /**
     * @param array<int<1,max>, \Twint\Sdk\Generated\Type\PaymentAmountType> $PaymentAmount
     */
    public function withPaymentAmount(array $PaymentAmount): static
    {
        $new = clone $this;
        $new->PaymentAmount = $PaymentAmount;

        return $new;
    }

    public function getBNPLData(): ?BNPLDataType
    {
        return $this->BNPLData;
    }

    public function withBNPLData(?BNPLDataType $BNPLData): static
    {
        $new = clone $this;
        $new->BNPLData = $BNPLData;

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
}
