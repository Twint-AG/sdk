<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use AllowDynamicProperties;

#[AllowDynamicProperties]
final class MerchantInformationBaseType
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
    private $CashRegisterId;

    /**
     * @var string
     */
    private $ServiceAgentUuid;

    /**
     * @return string
     */
    public function getMerchantUuid()
    {
        return $this->MerchantUuid;
    }

    /**
     * @param string $MerchantUuid
     * @return MerchantInformationBaseType
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
     * @return MerchantInformationBaseType
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
    public function getCashRegisterId()
    {
        return $this->CashRegisterId;
    }

    /**
     * @param string $CashRegisterId
     * @return MerchantInformationBaseType
     */
    public function withCashRegisterId($CashRegisterId)
    {
        $new = clone $this;
        $new->CashRegisterId = $CashRegisterId;

        return $new;
    }

    /**
     * @return string
     */
    public function getServiceAgentUuid()
    {
        return $this->ServiceAgentUuid;
    }

    /**
     * @param string $ServiceAgentUuid
     * @return MerchantInformationBaseType
     */
    public function withServiceAgentUuid($ServiceAgentUuid)
    {
        $new = clone $this;
        $new->ServiceAgentUuid = $ServiceAgentUuid;

        return $new;
    }
}
