<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use AllowDynamicProperties;
use Phpro\SoapClient\Type\ResultInterface;

#[AllowDynamicProperties]
final class StartOrderAndUofRegistrationResponseType implements ResultInterface
{
    /**
     * @var TWINTTokenType
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
     * @var OrderStatusType
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
     * @return TWINTTokenType
     */
    public function getToken()
    {
        return $this->Token;
    }

    /**
     * @param TWINTTokenType $Token
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
     * @return OrderStatusType
     */
    public function getPaymentOrderStatus()
    {
        return $this->PaymentOrderStatus;
    }

    /**
     * @param OrderStatusType $PaymentOrderStatus
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
