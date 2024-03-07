<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use Phpro\SoapClient\Type\RequestInterface;

final class IsUofConnectionActiveRequestType implements RequestInterface
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
    private $CustomerRelationUuid;

    /**
     * Constructor
     *
     * @param string $MerchantUuid
     * @param string $MerchantAliasId
     * @param string $CustomerRelationUuid
     */
    public function __construct($MerchantUuid, $MerchantAliasId, $CustomerRelationUuid)
    {
        $this->MerchantUuid = $MerchantUuid;
        $this->MerchantAliasId = $MerchantAliasId;
        $this->CustomerRelationUuid = $CustomerRelationUuid;
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
     * @return IsUofConnectionActiveRequestType
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
     * @return IsUofConnectionActiveRequestType
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
    public function getCustomerRelationUuid()
    {
        return $this->CustomerRelationUuid;
    }

    /**
     * @param string $CustomerRelationUuid
     * @return IsUofConnectionActiveRequestType
     */
    public function withCustomerRelationUuid($CustomerRelationUuid)
    {
        $new = clone $this;
        $new->CustomerRelationUuid = $CustomerRelationUuid;

        return $new;
    }
}
