<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use AllowDynamicProperties;
use DateTimeInterface;
use Phpro\SoapClient\Type\ResultInterface;

#[AllowDynamicProperties]
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

    /**
     * @param DateTimeInterface $CertificateExpiryDate
     * @return GetCertificateValidityResponseType
     */
    public function withCertificateExpiryDate($CertificateExpiryDate)
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

    /**
     * @param bool $RenewalAllowed
     * @return GetCertificateValidityResponseType
     */
    public function withRenewalAllowed($RenewalAllowed)
    {
        $new = clone $this;
        $new->RenewalAllowed = $RenewalAllowed;

        return $new;
    }
}
