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

    public function withMerchantInformation(MerchantInformationType $MerchantInformation): self
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

    public function withOrderUuid(string $OrderUuid): self
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

    public function withMerchantTransactionReference(string $MerchantTransactionReference): self
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
}
