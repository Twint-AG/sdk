<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use DateTimeInterface;
use Phpro\SoapClient\Type\ResultInterface;

class RenewCertificateResponseType implements ResultInterface
{
    protected mixed $MerchantCertificate;

    protected DateTimeInterface $ExpirationDate;

    public function getMerchantCertificate(): mixed
    {
        return $this->MerchantCertificate;
    }

    public function withMerchantCertificate(mixed $MerchantCertificate): static
    {
        $new = clone $this;
        $new->MerchantCertificate = $MerchantCertificate;

        return $new;
    }

    public function getExpirationDate(): DateTimeInterface
    {
        return $this->ExpirationDate;
    }

    public function withExpirationDate(DateTimeInterface $ExpirationDate): static
    {
        $new = clone $this;
        $new->ExpirationDate = $ExpirationDate;

        return $new;
    }
}
