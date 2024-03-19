<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use AllowDynamicProperties;
use Phpro\SoapClient\Type\RequestInterface;

#[AllowDynamicProperties]
final class GetCertificateValidityRequestType implements RequestInterface
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
     * Constructor
     *
     * @param string $MerchantUuid
     * @param string $MerchantAliasId
     */
    public function __construct($MerchantUuid, $MerchantAliasId)
    {
        $this->MerchantUuid = $MerchantUuid;
        $this->MerchantAliasId = $MerchantAliasId;
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
     * @return GetCertificateValidityRequestType
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
     * @return GetCertificateValidityRequestType
     */
    public function withMerchantAliasId($MerchantAliasId)
    {
        $new = clone $this;
        $new->MerchantAliasId = $MerchantAliasId;

        return $new;
    }
}
