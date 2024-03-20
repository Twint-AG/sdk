<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

final class CheckInNotificationType
{
    /**
     * @var MerchantInformationType
     */
    private $MerchantInformation;

    /**
     * @var CustomerInformationType
     */
    private $CustomerInformation;

    /**
     * @var string
     */
    private $PairingUuid;

    /**
     * @var string
     */
    private $PairingStatus;

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
     * @return CustomerInformationType
     */
    public function getCustomerInformation()
    {
        return $this->CustomerInformation;
    }

    public function withCustomerInformation(CustomerInformationType $CustomerInformation): self
    {
        $new = clone $this;
        $new->CustomerInformation = $CustomerInformation;

        return $new;
    }

    /**
     * @return string
     */
    public function getPairingUuid()
    {
        return $this->PairingUuid;
    }

    public function withPairingUuid(string $PairingUuid): self
    {
        $new = clone $this;
        $new->PairingUuid = $PairingUuid;

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
}
