<?php

namespace Twint\Sdk\Generated\Type;

use Phpro\SoapClient\Type\ResultInterface;

class StartOrderAndUofRegistrationResponseType implements ResultInterface
{
    /**
     * @var \Twint\Sdk\Generated\Type\TWINTTokenType
     */
    private $Token;

    /**
     * @var string
     */
    private $TwintURL;

    /**
     * @var string
     */
    private $PairingStatus;

    /**
     * @var string
     */
    private $PaymentOrderUuid;

    /**
     * @var \Twint\Sdk\Generated\Type\OrderStatusType
     */
    private $PaymentOrderStatus;

    /**
     * @var string
     */
    private $RegistrationUuid;

    /**
     * @var string
     */
    private $RegistrationStatus;

    /**
     * @return \Twint\Sdk\Generated\Type\TWINTTokenType
     */
    public function getToken()
    {
        return $this->Token;
    }

    /**
     * @param \Twint\Sdk\Generated\Type\TWINTTokenType $Token
     * @return StartOrderAndUofRegistrationResponseType
     */
    public function withToken($Token)
    {
        $new = clone $this;
        $new->Token = $Token;

        return $new;
    }

    /**
     * @return string
     */
    public function getTwintURL()
    {
        return $this->TwintURL;
    }

    /**
     * @param string $TwintURL
     * @return StartOrderAndUofRegistrationResponseType
     */
    public function withTwintURL($TwintURL)
    {
        $new = clone $this;
        $new->TwintURL = $TwintURL;

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
     * @return StartOrderAndUofRegistrationResponseType
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
     * @return StartOrderAndUofRegistrationResponseType
     */
    public function withPaymentOrderUuid($PaymentOrderUuid)
    {
        $new = clone $this;
        $new->PaymentOrderUuid = $PaymentOrderUuid;

        return $new;
    }

    /**
     * @return \Twint\Sdk\Generated\Type\OrderStatusType
     */
    public function getPaymentOrderStatus()
    {
        return $this->PaymentOrderStatus;
    }

    /**
     * @param \Twint\Sdk\Generated\Type\OrderStatusType $PaymentOrderStatus
     * @return StartOrderAndUofRegistrationResponseType
     */
    public function withPaymentOrderStatus($PaymentOrderStatus)
    {
        $new = clone $this;
        $new->PaymentOrderStatus = $PaymentOrderStatus;

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
     * @return StartOrderAndUofRegistrationResponseType
     */
    public function withRegistrationUuid($RegistrationUuid)
    {
        $new = clone $this;
        $new->RegistrationUuid = $RegistrationUuid;

        return $new;
    }

    /**
     * @return string
     */
    public function getRegistrationStatus()
    {
        return $this->RegistrationStatus;
    }

    /**
     * @param string $RegistrationStatus
     * @return StartOrderAndUofRegistrationResponseType
     */
    public function withRegistrationStatus($RegistrationStatus)
    {
        $new = clone $this;
        $new->RegistrationStatus = $RegistrationStatus;

        return $new;
    }
}

