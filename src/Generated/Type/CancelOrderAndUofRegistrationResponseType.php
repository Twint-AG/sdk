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

    public function withPaymentOrderUuid(string $PaymentOrderUuid): self
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

    public function withPaymentOrder(OrderType $PaymentOrder): self
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

    public function withRegistrationUuid(string $RegistrationUuid): self
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

    public function withRegistrationOrder(RegistrationType $RegistrationOrder): self
    {
        $new = clone $this;
        $new->RegistrationOrder = $RegistrationOrder;

        return $new;
    }
}
