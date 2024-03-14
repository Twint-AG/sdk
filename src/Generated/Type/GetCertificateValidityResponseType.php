<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use DateTimeInterface;
use Phpro\SoapClient\Type\ResultInterface;

class GetCertificateValidityResponseType implements ResultInterface
{
    protected DateTimeInterface $CertificateExpiryDate;

    protected bool $RenewalAllowed;

    public function getCertificateExpiryDate(): DateTimeInterface
    {
        return $this->CertificateExpiryDate;
    }

    public function withCertificateExpiryDate(DateTimeInterface $CertificateExpiryDate): static
    {
        $new = clone $this;
        $new->CertificateExpiryDate = $CertificateExpiryDate;

        return $new;
    }

    public function getRenewalAllowed(): bool
    {
        return $this->RenewalAllowed;
    }

    public function withRenewalAllowed(bool $RenewalAllowed): static
    {
        $new = clone $this;
        $new->RenewalAllowed = $RenewalAllowed;

        return $new;
    }
}
