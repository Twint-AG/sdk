<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use Phpro\SoapClient\Type\ResultInterface;

final class MonitorOrderResponseType implements ResultInterface
{
    /**
     * @var MerchantInformationType
     */
    private $MerchantInformation;

    /**
     * @var OrderType
     */
    private $Order;

    /**
     * @var string
     */
    private $PairingStatus;

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

    public function withMerchantInformation(MerchantInformationType $MerchantInformation): self
    {
        $new = clone $this;
        $new->MerchantInformation = $MerchantInformation;

        return $new;
    }

    /**
     * @return OrderType
     */
    public function getOrder()
    {
        return $this->Order;
    }

    public function withOrder(OrderType $Order): self
    {
        $new = clone $this;
        $new->Order = $Order;

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
    public function getCustomerRelationUuid()
    {
        return $this->CustomerRelationUuid;
    }

    public function withCustomerRelationUuid(string $CustomerRelationUuid): self
    {
        $new = clone $this;
        $new->CustomerRelationUuid = $CustomerRelationUuid;

        return $new;
    }
}
