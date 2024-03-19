<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use AllowDynamicProperties;
use DateTimeInterface;
use Phpro\SoapClient\Type\ResultInterface;

#[AllowDynamicProperties]
final class RenewCertificateResponseType implements ResultInterface
{
    /**
     * @var string
     */
    private $MerchantCertificate;

    /**
     * @var DateTimeInterface
     */
    private $ExpirationDate;

    /**
     * @return string
     */
    public function getMerchantCertificate()
    {
        return $this->MerchantCertificate;
    }

    /**
     * @param string $MerchantCertificate
     * @return RenewCertificateResponseType
     */
    public function withMerchantCertificate($MerchantCertificate)
    {
        $new = clone $this;
        $new->MerchantCertificate = $MerchantCertificate;

        return $new;
    }

    /**
     * @return DateTimeInterface
     */
    public function getExpirationDate()
    {
        return $this->ExpirationDate;
    }

    /**
     * @param DateTimeInterface $ExpirationDate
     * @return RenewCertificateResponseType
     */
    public function withExpirationDate($ExpirationDate)
    {
        $new = clone $this;
        $new->ExpirationDate = $ExpirationDate;

        return $new;
    }
}
