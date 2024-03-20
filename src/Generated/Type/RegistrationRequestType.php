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

    public function withMerchantCredential(string $MerchantCredential): self
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

    public function withMerchantRegistrationReference(string $MerchantRegistrationReference): self
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

    public function withAliasLifetime(string $AliasLifetime): self
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

    public function withEnforceRegistration(bool $EnforceRegistration): self
    {
        $new = clone $this;
        $new->EnforceRegistration = $EnforceRegistration;

        return $new;
    }
}
