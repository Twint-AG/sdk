<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

final class RegistrationRequestType
{
    /**
     * @var string
     */
    private $MerchantCredential;

    /**
     * @var string
     */
    private $MerchantRegistrationReference;

    /**
     * @var string
     */
    private $AliasLifetime;

    /**
     * @var bool
     */
    private $EnforceRegistration;

    /**
     * @return string
     */
    public function getMerchantCredential()
    {
        return $this->MerchantCredential;
    }

    /**
     * @param string $MerchantCredential
     * @return RegistrationRequestType
     */
    public function withMerchantCredential($MerchantCredential)
    {
        $new = clone $this;
        $new->MerchantCredential = $MerchantCredential;

        return $new;
    }

    /**
     * @return string
     */
    public function getMerchantRegistrationReference()
    {
        return $this->MerchantRegistrationReference;
    }

    /**
     * @param string $MerchantRegistrationReference
     * @return RegistrationRequestType
     */
    public function withMerchantRegistrationReference($MerchantRegistrationReference)
    {
        $new = clone $this;
        $new->MerchantRegistrationReference = $MerchantRegistrationReference;

        return $new;
    }

    /**
     * @return string
     */
    public function getAliasLifetime()
    {
        return $this->AliasLifetime;
    }

    /**
     * @param string $AliasLifetime
     * @return RegistrationRequestType
     */
    public function withAliasLifetime($AliasLifetime)
    {
        $new = clone $this;
        $new->AliasLifetime = $AliasLifetime;

        return $new;
    }

    /**
     * @return bool
     */
    public function getEnforceRegistration()
    {
        return $this->EnforceRegistration;
    }

    /**
     * @param bool $EnforceRegistration
     * @return RegistrationRequestType
     */
    public function withEnforceRegistration($EnforceRegistration)
    {
        $new = clone $this;
        $new->EnforceRegistration = $EnforceRegistration;

        return $new;
    }
}
