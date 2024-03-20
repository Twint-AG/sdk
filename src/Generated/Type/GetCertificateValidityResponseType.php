<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use DateTimeInterface;
use Phpro\SoapClient\Type\ResultInterface;

final class GetCertificateValidityResponseType implements ResultInterface
{
    /**
     * @var DateTimeInterface
     */
    private $CertificateExpiryDate;

    /**
     * @var bool
     */
    private $RenewalAllowed;

    /**
     * @return DateTimeInterface
     */
    public function getCertificateExpiryDate()
    {
        return $this->CertificateExpiryDate;
    }

    public function withCertificateExpiryDate(DateTimeInterface $CertificateExpiryDate): self
    {
        $new = clone $this;
        $new->CertificateExpiryDate = $CertificateExpiryDate;

        return $new;
    }

    /**
     * @return bool
     */
    public function getRenewalAllowed()
    {
        return $this->RenewalAllowed;
    }

    public function withRenewalAllowed(bool $RenewalAllowed): self
    {
        $new = clone $this;
        $new->RenewalAllowed = $RenewalAllowed;

        return $new;
    }
}
