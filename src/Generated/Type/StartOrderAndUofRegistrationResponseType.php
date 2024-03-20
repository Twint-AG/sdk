<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use Phpro\SoapClient\Type\ResultInterface;

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

    public function withToken(TWINTTokenType $Token): self
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

    public function withTwintURL(string $TwintURL): self
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

    public function withPairingStatus(string $PairingStatus): self
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

    public function withPaymentOrderUuid(string $PaymentOrderUuid): self
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

    public function withPaymentOrderStatus(OrderStatusType $PaymentOrderStatus): self
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

    public function withRegistrationUuid(string $RegistrationUuid): self
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

    public function withRegistrationStatus(string $RegistrationStatus): self
    {
        $new = clone $this;
        $new->RegistrationStatus = $RegistrationStatus;

        return $new;
    }
}
