<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use Phpro\SoapClient\Type\ResultInterface;

class CancelOrderAndUofRegistrationResponseType implements ResultInterface
{
    /**
     * Base type: restriction of xs:string Pattern: [A-Fa-f0-9]{32}|(\{|\()?[A-Fa-f0-9]{8}-([A-Fa-f0-9]{4}-){3}[A-Fa-f0-9]{12}(\}|\))? This type is used by other XML schema attributes or elements that will
     *  hold a universal unique identifier (UUID), commonly known as either a globally unique identifier (GUID) or UUID. The regular expression defined limits the contents of an attribute to either a
     *  single 32-digit hexadecimal string or a 32-digit hex string patterned as [8]-[4]-[4]-[4]-[12] digits.
     */
    protected string $PaymentOrderUuid;

    protected OrderType $PaymentOrder;

    /**
     * Base type: restriction of xs:string Pattern: [A-Fa-f0-9]{32}|(\{|\()?[A-Fa-f0-9]{8}-([A-Fa-f0-9]{4}-){3}[A-Fa-f0-9]{12}(\}|\))? This type is used by other XML schema attributes or elements that will
     *  hold a universal unique identifier (UUID), commonly known as either a globally unique identifier (GUID) or UUID. The regular expression defined limits the contents of an attribute to either a
     *  single 32-digit hexadecimal string or a 32-digit hex string patterned as [8]-[4]-[4]-[4]-[12] digits.
     */
    protected string $RegistrationUuid;

    protected RegistrationType $RegistrationOrder;

    public function getPaymentOrderUuid(): string
    {
        return $this->PaymentOrderUuid;
    }

    public function withPaymentOrderUuid(string $PaymentOrderUuid): static
    {
        $new = clone $this;
        $new->PaymentOrderUuid = $PaymentOrderUuid;

        return $new;
    }

    public function getPaymentOrder(): OrderType
    {
        return $this->PaymentOrder;
    }

    public function withPaymentOrder(OrderType $PaymentOrder): static
    {
        $new = clone $this;
        $new->PaymentOrder = $PaymentOrder;

        return $new;
    }

    public function getRegistrationUuid(): string
    {
        return $this->RegistrationUuid;
    }

    public function withRegistrationUuid(string $RegistrationUuid): static
    {
        $new = clone $this;
        $new->RegistrationUuid = $RegistrationUuid;

        return $new;
    }

    public function getRegistrationOrder(): RegistrationType
    {
        return $this->RegistrationOrder;
    }

    public function withRegistrationOrder(RegistrationType $RegistrationOrder): static
    {
        $new = clone $this;
        $new->RegistrationOrder = $RegistrationOrder;

        return $new;
    }
}
