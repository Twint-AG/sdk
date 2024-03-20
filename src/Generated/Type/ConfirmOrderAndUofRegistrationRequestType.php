<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use Phpro\SoapClient\Type\RequestInterface;

final class ConfirmOrderAndUofRegistrationRequestType implements RequestInterface
{
    /**
     * @var MerchantInformationType
     */
    private $MerchantInformation;

    /**
     * @var string
     */
    private $PaymentOrderUuid;

    /**
     * @var string
     */
    private $MerchantTransactionReference;

    /**
     * @var bool
     */
    private $ConfirmPaymentOrder;

    /**
     * @var CurrencyAmountType
     */
    private $RequestedAmount;

    /**
     * @var bool
     */
    private $PartialConfirmation;

    /**
     * @var bool
     */
    private $ConfirmRegistration;

    /**
     * Constructor
     *
     * @param MerchantInformationType $MerchantInformation
     * @param string $PaymentOrderUuid
     * @param string $MerchantTransactionReference
     * @param bool $ConfirmPaymentOrder
     * @param CurrencyAmountType $RequestedAmount
     * @param bool $PartialConfirmation
     * @param bool $ConfirmRegistration
     */
    public function __construct($MerchantInformation, $PaymentOrderUuid, $MerchantTransactionReference, $ConfirmPaymentOrder, $RequestedAmount, $PartialConfirmation, $ConfirmRegistration)
    {
        $this->MerchantInformation = $MerchantInformation;
        $this->PaymentOrderUuid = $PaymentOrderUuid;
        $this->MerchantTransactionReference = $MerchantTransactionReference;
        $this->ConfirmPaymentOrder = $ConfirmPaymentOrder;
        $this->RequestedAmount = $RequestedAmount;
        $this->PartialConfirmation = $PartialConfirmation;
        $this->ConfirmRegistration = $ConfirmRegistration;
    }

    /**
     * @return MerchantInformationType
     */
    public function getMerchantInformation()
    {
        return $this->MerchantInformation;
    }

    public function withMerchantInformation(MerchantInformationType $MerchantInformation): self
    {
        $new = clone $this;
        $new->MerchantInformation = $MerchantInformation;

        return $new;
    }

    /**
     * @return string
     */
    public function getPaymentOrderUuid()
    {
        return $this->PaymentOrderUuid;
    }

    public function withPaymentOrderUuid(string $PaymentOrderUuid): self
    {
        $new = clone $this;
        $new->PaymentOrderUuid = $PaymentOrderUuid;

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

    /**
     * @return bool
     */
    public function getConfirmPaymentOrder()
    {
        return $this->ConfirmPaymentOrder;
    }

    public function withConfirmPaymentOrder(bool $ConfirmPaymentOrder): self
    {
        $new = clone $this;
        $new->ConfirmPaymentOrder = $ConfirmPaymentOrder;

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
     * @return bool
     */
    public function getPartialConfirmation()
    {
        return $this->PartialConfirmation;
    }

    public function withPartialConfirmation(bool $PartialConfirmation): self
    {
        $new = clone $this;
        $new->PartialConfirmation = $PartialConfirmation;

        return $new;
    }

    /**
     * @return bool
     */
    public function getConfirmRegistration()
    {
        return $this->ConfirmRegistration;
    }

    public function withConfirmRegistration(bool $ConfirmRegistration): self
    {
        $new = clone $this;
        $new->ConfirmRegistration = $ConfirmRegistration;

        return $new;
    }
}
