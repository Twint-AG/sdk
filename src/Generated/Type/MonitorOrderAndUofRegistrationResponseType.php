<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use Phpro\SoapClient\Type\ResultInterface;

final class MonitorOrderAndUofRegistrationResponseType implements ResultInterface
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
     * @var string
     */
    private $CustomerRelationUuid;

    /**
     * @return MerchantInformationType
     */
    public function getMerchantInformation()
    {
        return $this->MerchantInformation;
    }

    /**
     * @param MerchantInformationType $MerchantInformation
     * @return MonitorOrderAndUofRegistrationResponseType
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
     * @return MonitorOrderAndUofRegistrationResponseType
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
     * @return MonitorOrderAndUofRegistrationResponseType
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
     * @return MonitorOrderAndUofRegistrationResponseType
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
     * @return MonitorOrderAndUofRegistrationResponseType
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
     * @return MonitorOrderAndUofRegistrationResponseType
     */
    public function withRegistrationOrder($RegistrationOrder)
    {
        $new = clone $this;
        $new->RegistrationOrder = $RegistrationOrder;

        return $new;
    }

    /**
     * @return string
     */
    public function getCustomerRelationUuid()
    {
        return $this->CustomerRelationUuid;
    }

    /**
     * @param string $CustomerRelationUuid
     * @return MonitorOrderAndUofRegistrationResponseType
     */
    public function withCustomerRelationUuid($CustomerRelationUuid)
    {
        $new = clone $this;
        $new->CustomerRelationUuid = $CustomerRelationUuid;

        return $new;
    }
}
