<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

final class RegistrationType
{
    /**
     * @var string
     */
    private $RegistrationStatus;

    /**
     * @var string
     */
    private $UofCustomerRelationUuid;

    /**
     * @var string
     */
    private $ConfirmedMerchantCredential;

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

    /**
     * @return string
     */
    public function getUofCustomerRelationUuid()
    {
        return $this->UofCustomerRelationUuid;
    }

    public function withUofCustomerRelationUuid(string $UofCustomerRelationUuid): self
    {
        $new = clone $this;
        $new->UofCustomerRelationUuid = $UofCustomerRelationUuid;

        return $new;
    }

    /**
     * @return string
     */
    public function getConfirmedMerchantCredential()
    {
        return $this->ConfirmedMerchantCredential;
    }

    public function withConfirmedMerchantCredential(string $ConfirmedMerchantCredential): self
    {
        $new = clone $this;
        $new->ConfirmedMerchantCredential = $ConfirmedMerchantCredential;

        return $new;
    }
}
