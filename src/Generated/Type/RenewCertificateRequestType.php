<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use Phpro\SoapClient\Type\RequestInterface;

final class RenewCertificateRequestType implements RequestInterface
{
    /**
     * @var string
     */
    private $MerchantUuid;

    /**
     * @var string
     */
    private $MerchantAliasId;

    /**
     * @var string
     */
    private $CertificatePassword;

    /**
     * Constructor
     *
     * @param string $MerchantUuid
     * @param string $MerchantAliasId
     * @param string $CertificatePassword
     */
    public function __construct($MerchantUuid, $MerchantAliasId, $CertificatePassword)
    {
        $this->MerchantUuid = $MerchantUuid;
        $this->MerchantAliasId = $MerchantAliasId;
        $this->CertificatePassword = $CertificatePassword;
    }

    /**
     * @return string
     */
    public function getMerchantUuid()
    {
        return $this->MerchantUuid;
    }

    /**
     * @param string $MerchantUuid
     * @return RenewCertificateRequestType
     */
    public function withMerchantUuid($MerchantUuid)
    {
        $new = clone $this;
        $new->MerchantUuid = $MerchantUuid;

        return $new;
    }

    /**
     * @return string
     */
    public function getMerchantAliasId()
    {
        return $this->MerchantAliasId;
    }

    /**
     * @param string $MerchantAliasId
     * @return RenewCertificateRequestType
     */
    public function withMerchantAliasId($MerchantAliasId)
    {
        $new = clone $this;
        $new->MerchantAliasId = $MerchantAliasId;

        return $new;
    }

    /**
     * @return string
     */
    public function getCertificatePassword()
    {
        return $this->CertificatePassword;
    }

    /**
     * @param string $CertificatePassword
     * @return RenewCertificateRequestType
     */
    public function withCertificatePassword($CertificatePassword)
    {
        $new = clone $this;
        $new->CertificatePassword = $CertificatePassword;

        return $new;
    }
}
