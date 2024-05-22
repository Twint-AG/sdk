<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

class RegistrationRequestType
{
    protected mixed $MerchantCredential;

    /**
     * Reference number by which the merchant might want to identify
     *  this voucher in his own applications.
     */
    protected ?string $MerchantRegistrationReference = null;

    /**
     * @var null | mixed
     */
    protected mixed $AliasLifetime = null;

    protected bool $EnforceRegistration;

    public function getMerchantCredential(): mixed
    {
        return $this->MerchantCredential;
    }

    public function withMerchantCredential(mixed $MerchantCredential): static
    {
        $new = clone $this;
        $new->MerchantCredential = $MerchantCredential;

        return $new;
    }

    public function getMerchantRegistrationReference(): ?string
    {
        return $this->MerchantRegistrationReference;
    }

    public function withMerchantRegistrationReference(?string $MerchantRegistrationReference): static
    {
        $new = clone $this;
        $new->MerchantRegistrationReference = $MerchantRegistrationReference;

        return $new;
    }

    /**
     * @return null | mixed
     */
    public function getAliasLifetime(): mixed
    {
        return $this->AliasLifetime;
    }

    /**
     * @param null | mixed $AliasLifetime
     */
    public function withAliasLifetime(mixed $AliasLifetime): static
    {
        $new = clone $this;
        $new->AliasLifetime = $AliasLifetime;

        return $new;
    }

    public function getEnforceRegistration(): bool
    {
        return $this->EnforceRegistration;
    }

    public function withEnforceRegistration(bool $EnforceRegistration): static
    {
        $new = clone $this;
        $new->EnforceRegistration = $EnforceRegistration;

        return $new;
    }
}
