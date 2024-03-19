<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use AllowDynamicProperties;

#[AllowDynamicProperties]
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

    /**
     * @param MerchantInformationType $MerchantInformation
     * @return CheckInNotificationType
     */
    public function withMerchantInformation($MerchantInformation)
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

    /**
     * @param CustomerInformationType $CustomerInformation
     * @return CheckInNotificationType
     */
    public function withCustomerInformation($CustomerInformation)
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

    /**
     * @param string $PairingUuid
     * @return CheckInNotificationType
     */
    public function withPairingUuid($PairingUuid)
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

    /**
     * @param string $PairingStatus
     * @return CheckInNotificationType
     */
    public function withPairingStatus($PairingStatus)
    {
        $new = clone $this;
        $new->PairingStatus = $PairingStatus;

        return $new;
    }
}
