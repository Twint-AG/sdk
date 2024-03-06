<?php

namespace Twint\Sdk\Generated\Type;

use Phpro\SoapClient\Type\ResultInterface;

class ConfirmOrderAndUofRegistrationResponseType implements ResultInterface
{
    /**
     * @var \Twint\Sdk\Generated\Type\MerchantInformationType
     */
    private $MerchantInformation;

    /**
     * @var string
     */
    private $PairingStatus;

    /**
     * @var string
     */
    private $PaymentOrderUuid;

    /**
     * @var \Twint\Sdk\Generated\Type\OrderType
     */
    private $PaymentOrder;

    /**
     * @var string
     */
    private $RegistrationUuid;

    /**
     * @var \Twint\Sdk\Generated\Type\RegistrationType
     */
    private $RegistrationOrder;

    /**
     * @return \Twint\Sdk\Generated\Type\MerchantInformationType
     */
    public function getMerchantInformation()
    {
        return $this->MerchantInformation;
    }

    /**
     * @param \Twint\Sdk\Generated\Type\MerchantInformationType $MerchantInformation
     * @return ConfirmOrderAndUofRegistrationResponseType
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
    public function getPairingStatus()
    {
        return $this->PairingStatus;
    }

    /**
     * @param string $PairingStatus
     * @return ConfirmOrderAndUofRegistrationResponseType
     */
    public function withPairingStatus($PairingStatus)
    {
        $new = clone $this;
        $new->PairingStatus = $PairingStatus;

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
     * @return ConfirmOrderAndUofRegistrationResponseType
     */
    public function withPaymentOrderUuid($PaymentOrderUuid)
    {
        $new = clone $this;
        $new->PaymentOrderUuid = $PaymentOrderUuid;

        return $new;
    }

    /**
     * @return \Twint\Sdk\Generated\Type\OrderType
     */
    public function getPaymentOrder()
    {
        return $this->PaymentOrder;
    }

    /**
     * @param \Twint\Sdk\Generated\Type\OrderType $PaymentOrder
     * @return ConfirmOrderAndUofRegistrationResponseType
     */
    public function withPaymentOrder($PaymentOrder)
    {
        $new = clone $this;
        $new->PaymentOrder = $PaymentOrder;

        return $new;
    }

    /**
     * @return string
     */
    public function getRegistrationUuid()
    {
        return $this->RegistrationUuid;
    }

    /**
     * @param string $RegistrationUuid
     * @return ConfirmOrderAndUofRegistrationResponseType
     */
    public function withRegistrationUuid($RegistrationUuid)
    {
        $new = clone $this;
        $new->RegistrationUuid = $RegistrationUuid;

        return $new;
    }

    /**
     * @return \Twint\Sdk\Generated\Type\RegistrationType
     */
    public function getRegistrationOrder()
    {
        return $this->RegistrationOrder;
    }

    /**
     * @param \Twint\Sdk\Generated\Type\RegistrationType $RegistrationOrder
     * @return ConfirmOrderAndUofRegistrationResponseType
     */
    public function withRegistrationOrder($RegistrationOrder)
    {
        $new = clone $this;
        $new->RegistrationOrder = $RegistrationOrder;

        return $new;
    }
}

