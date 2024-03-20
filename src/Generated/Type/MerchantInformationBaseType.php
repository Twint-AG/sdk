<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

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

    public function withMerchantUuid(string $MerchantUuid): self
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

    public function withMerchantAliasId(string $MerchantAliasId): self
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

    public function withCashRegisterId(string $CashRegisterId): self
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

    public function withServiceAgentUuid(string $ServiceAgentUuid): self
    {
        $new = clone $this;
        $new->ServiceAgentUuid = $ServiceAgentUuid;

        return $new;
    }
}
