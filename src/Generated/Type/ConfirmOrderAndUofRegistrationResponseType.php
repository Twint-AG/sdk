<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use Phpro\SoapClient\Type\ResultInterface;

final class ConfirmOrderAndUofRegistrationResponseType implements ResultInterface
{
    /**
     * @var MerchantInformationType
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
