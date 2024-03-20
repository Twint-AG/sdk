<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use DateTimeInterface;
use Phpro\SoapClient\Type\ResultInterface;

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

    public function withMerchantCertificate(string $MerchantCertificate): self
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

    public function withExpirationDate(DateTimeInterface $ExpirationDate): self
    {
        $new = clone $this;
        $new->ExpirationDate = $ExpirationDate;

        return $new;
    }
}
