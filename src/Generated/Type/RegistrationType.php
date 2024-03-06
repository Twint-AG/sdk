<?php

namespace Twint\Sdk\Generated\Type;

class RegistrationType
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

    /**
     * @param string $RegistrationStatus
     * @return RegistrationType
     */
    public function withRegistrationStatus($RegistrationStatus)
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

    /**
     * @param string $UofCustomerRelationUuid
     * @return RegistrationType
     */
    public function withUofCustomerRelationUuid($UofCustomerRelationUuid)
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

    /**
     * @param string $ConfirmedMerchantCredential
     * @return RegistrationType
     */
    public function withConfirmedMerchantCredential($ConfirmedMerchantCredential)
    {
        $new = clone $this;
        $new->ConfirmedMerchantCredential = $ConfirmedMerchantCredential;

        return $new;
    }
}

