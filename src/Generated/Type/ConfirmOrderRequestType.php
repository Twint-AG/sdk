<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use Phpro\SoapClient\Type\RequestInterface;

final class ConfirmOrderRequestType implements RequestInterface
{
    /**
     * @var MerchantInformationType
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
     * @var CurrencyAmountType
     */
    private $RequestedAmount;

    /**
     * @var bool
     */
    private $PartialConfirmation;

    /**
     * Constructor
     *
     * @param MerchantInformationType $MerchantInformation
     * @param string $OrderUuid
     * @param string $MerchantTransactionReference
     * @param CurrencyAmountType $RequestedAmount
     * @param bool $PartialConfirmation
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
     * @return MerchantInformationType
     */
    public function getMerchantInformation()
    {
        return $this->MerchantInformation;
    }

    /**
     * @param MerchantInformationType $MerchantInformation
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
     * @return CurrencyAmountType
     */
    public function getRequestedAmount()
    {
        return $this->RequestedAmount;
    }

    /**
     * @param CurrencyAmountType $RequestedAmount
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
