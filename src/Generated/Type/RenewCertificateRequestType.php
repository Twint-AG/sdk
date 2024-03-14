<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use Phpro\SoapClient\Type\RequestInterface;

class RenewCertificateRequestType implements RequestInterface
{
    /**
     * Base type: restriction of xs:string Pattern: [A-Fa-f0-9]{32}|(\{|\()?[A-Fa-f0-9]{8}-([A-Fa-f0-9]{4}-){3}[A-Fa-f0-9]{12}(\}|\))? This type is used by other XML schema attributes or elements that will
     *  hold a universal unique identifier (UUID), commonly known as either a globally unique identifier (GUID) or UUID. The regular expression defined limits the contents of an attribute to either a
     *  single 32-digit hexadecimal string or a 32-digit hex string patterned as [8]-[4]-[4]-[4]-[12] digits.
     */
    protected ?string $MerchantUuid;

    protected ?string $MerchantAliasId;

    protected mixed $CertificatePassword;

    /**
     * Constructor
     */
    public function __construct(?string $MerchantUuid, ?string $MerchantAliasId, mixed $CertificatePassword)
    {
        $this->MerchantUuid = $MerchantUuid;
        $this->MerchantAliasId = $MerchantAliasId;
        $this->CertificatePassword = $CertificatePassword;
    }

    public function getMerchantUuid(): ?string
    {
        return $this->MerchantUuid;
    }

    public function withMerchantUuid(?string $MerchantUuid): static
    {
        $new = clone $this;
        $new->MerchantUuid = $MerchantUuid;

        return $new;
    }

    public function getMerchantAliasId(): ?string
    {
        return $this->MerchantAliasId;
    }

    public function withMerchantAliasId(?string $MerchantAliasId): static
    {
        $new = clone $this;
        $new->MerchantAliasId = $MerchantAliasId;

        return $new;
    }

    public function getCertificatePassword(): mixed
    {
        return $this->CertificatePassword;
    }

    public function withCertificatePassword(mixed $CertificatePassword): static
    {
        $new = clone $this;
        $new->CertificatePassword = $CertificatePassword;

        return $new;
    }
}
