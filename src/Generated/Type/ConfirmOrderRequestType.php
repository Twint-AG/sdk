<?php

namespace Twint\Sdk\Generated\Type;

use Phpro\SoapClient\Type\RequestInterface;

class ConfirmOrderRequestType implements RequestInterface
{
    /**
     * @var \Twint\Sdk\Generated\Type\MerchantInformationType
     */
    private $MerchantInformation;

    /**
     * @var string
     */
    private $OrderUuid;

    /**
     * @var string
     */
    private $MerchantTransactionReference;

    /**
     * @var \Twint\Sdk\Generated\Type\CurrencyAmountType
     */
    private $RequestedAmount;

    /**
     * @var bool
     */
    private $PartialConfirmation;

    /**
     * Constructor
     *
     * @var \Twint\Sdk\Generated\Type\MerchantInformationType $MerchantInformation
     * @var string $OrderUuid
     * @var string $MerchantTransactionReference
     * @var \Twint\Sdk\Generated\Type\CurrencyAmountType $RequestedAmount
     * @var bool $PartialConfirmation
     */
    public function __construct($MerchantInformation, $OrderUuid, $MerchantTransactionReference, $RequestedAmount, $PartialConfirmation)
    {
        $this->MerchantInformation = $MerchantInformation;
        $this->OrderUuid = $OrderUuid;
        $this->MerchantTransactionReference = $MerchantTransactionReference;
        $this->RequestedAmount = $RequestedAmount;
        $this->PartialConfirmation = $PartialConfirmation;
    }

    /**
     * @return \Twint\Sdk\Generated\Type\MerchantInformationType
     */
    public function getMerchantInformation()
    {
        return $this->MerchantInformation;
    }

    /**
     * @param \Twint\Sdk\Generated\Type\MerchantInformationType $MerchantInformation
     * @return ConfirmOrderRequestType
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
    public function getOrderUuid()
    {
        return $this->OrderUuid;
    }

    /**
     * @param string $OrderUuid
     * @return ConfirmOrderRequestType
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
    public function getMerchantTransactionReference()
    {
        return $this->MerchantTransactionReference;
    }

    /**
     * @param string $MerchantTransactionReference
     * @return ConfirmOrderRequestType
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
    public function getRequestedAmount()
    {
        return $this->RequestedAmount;
    }

    /**
     * @param \Twint\Sdk\Generated\Type\CurrencyAmountType $RequestedAmount
     * @return ConfirmOrderRequestType
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
     * @return ConfirmOrderRequestType
     */
    public function withPartialConfirmation($PartialConfirmation)
    {
        $new = clone $this;
        $new->PartialConfirmation = $PartialConfirmation;

        return $new;
    }
}

