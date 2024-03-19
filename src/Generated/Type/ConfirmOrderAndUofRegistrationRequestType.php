<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use AllowDynamicProperties;
use Phpro\SoapClient\Type\RequestInterface;

#[AllowDynamicProperties]
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
    public function __construct(
        $MerchantInformation,
        $PaymentOrderUuid,
        $MerchantTransactionReference,
        $ConfirmPaymentOrder,
        $RequestedAmount,
        $PartialConfirmation,
        $ConfirmRegistration
    ) {
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

    /**
     * @param MerchantInformationType $MerchantInformation
     * @return ConfirmOrderAndUofRegistrationRequestType
     */
    public function withMerchantInformation($MerchantInformation)
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

    /**
     * @param string $PaymentOrderUuid
     * @return ConfirmOrderAndUofRegistrationRequestType
     */
    public function withPaymentOrderUuid($PaymentOrderUuid)
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

    /**
     * @param string $MerchantTransactionReference
     * @return ConfirmOrderAndUofRegistrationRequestType
     */
    public function withMerchantTransactionReference($MerchantTransactionReference)
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

    /**
     * @param bool $ConfirmPaymentOrder
     * @return ConfirmOrderAndUofRegistrationRequestType
     */
    public function withConfirmPaymentOrder($ConfirmPaymentOrder)
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

    /**
     * @param CurrencyAmountType $RequestedAmount
     * @return ConfirmOrderAndUofRegistrationRequestType
     */
    public function withRequestedAmount($RequestedAmount)
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

    /**
     * @param bool $PartialConfirmation
     * @return ConfirmOrderAndUofRegistrationRequestType
     */
    public function withPartialConfirmation($PartialConfirmation)
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

    /**
     * @param bool $ConfirmRegistration
     * @return ConfirmOrderAndUofRegistrationRequestType
     */
    public function withConfirmRegistration($ConfirmRegistration)
    {
        $new = clone $this;
        $new->ConfirmRegistration = $ConfirmRegistration;

        return $new;
    }
}
