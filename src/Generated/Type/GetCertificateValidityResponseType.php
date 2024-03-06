<?php

namespace Twint\Sdk\Generated\Type;

use Phpro\SoapClient\Type\ResultInterface;

class GetCertificateValidityResponseType implements ResultInterface
{
    /**
     * @var \DateTimeInterface
     */
    private $CertificateExpiryDate;

    /**
     * @var bool
     */
    private $RenewalAllowed;

    /**
     * @return \DateTimeInterface
     */
    public function getCertificateExpiryDate()
    {
        return $this->CertificateExpiryDate;
    }

    /**
     * @param \DateTimeInterface $CertificateExpiryDate
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

