<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use AllowDynamicProperties;
use Phpro\SoapClient\Type\RequestInterface;

#[AllowDynamicProperties]
final class GetOrderRequestType implements RequestInterface
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
    private $OrderUuid;

    /**
     * Constructor
     *
     * @param string $MerchantUuid
     * @param string $MerchantAliasId
     * @param string $OrderUuid
     */
    public function __construct($MerchantUuid, $MerchantAliasId, $OrderUuid)
    {
        $this->MerchantUuid = $MerchantUuid;
        $this->MerchantAliasId = $MerchantAliasId;
        $this->OrderUuid = $OrderUuid;
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
     * @return GetOrderRequestType
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
     * @return GetOrderRequestType
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
    public function getOrderUuid()
    {
        return $this->OrderUuid;
    }

    /**
     * @param string $OrderUuid
     * @return GetOrderRequestType
     */
    public function withOrderUuid($OrderUuid)
    {
        $new = clone $this;
        $new->OrderUuid = $OrderUuid;

        return $new;
    }
}
