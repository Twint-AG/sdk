<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use Phpro\SoapClient\Type\ResultInterface;

final class CancelOrderAndUofRegistrationResponseType implements ResultInterface
{
    /**
     * @var string
     */
    private $PaymentOrderUuid;

    /**
     * @var OrderType
     */
    private $PaymentOrder;

    /**
     * @var string
     */
    private $RegistrationUuid;

    /**
     * @var RegistrationType
     */
    private $RegistrationOrder;

    /**
     * @return string
     */
    public function getPaymentOrderUuid()
    {
        return $this->PaymentOrderUuid;
    }

    /**
     * @param string $PaymentOrderUuid
     * @return CancelOrderAndUofRegistrationResponseType
     */
    public function withPaymentOrderUuid($PaymentOrderUuid)
    {
        $new = clone $this;
        $new->PaymentOrderUuid = $PaymentOrderUuid;

        return $new;
    }

    /**
     * @return OrderType
     */
    public function getPaymentOrder()
    {
        return $this->PaymentOrder;
    }

    /**
     * @param OrderType $PaymentOrder
     * @return CancelOrderAndUofRegistrationResponseType
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
     * @return CancelOrderAndUofRegistrationResponseType
     */
    public function withRegistrationUuid($RegistrationUuid)
    {
        $new = clone $this;
        $new->RegistrationUuid = $RegistrationUuid;

        return $new;
    }

    /**
     * @return RegistrationType
     */
    public function getRegistrationOrder()
    {
        return $this->RegistrationOrder;
    }

    /**
     * @param RegistrationType $RegistrationOrder
     * @return CancelOrderAndUofRegistrationResponseType
     */
    public function withRegistrationOrder($RegistrationOrder)
    {
        $new = clone $this;
        $new->RegistrationOrder = $RegistrationOrder;

        return $new;
    }
}
