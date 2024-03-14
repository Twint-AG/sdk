<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

class MerchantInformationBaseType
{
    /**
     * Base type: restriction of xs:string Pattern: [A-Fa-f0-9]{32}|(\{|\()?[A-Fa-f0-9]{8}-([A-Fa-f0-9]{4}-){3}[A-Fa-f0-9]{12}(\}|\))? This type is used by other XML schema attributes or elements that will
     *  hold a universal unique identifier (UUID), commonly known as either a globally unique identifier (GUID) or UUID. The regular expression defined limits the contents of an attribute to either a
     *  single 32-digit hexadecimal string or a 32-digit hex string patterned as [8]-[4]-[4]-[4]-[12] digits.
     */
    protected ?string $MerchantUuid;

    protected ?string $MerchantAliasId;

    protected ?string $CashRegisterId;

    /**
     * Base type: restriction of xs:string Pattern: [A-Fa-f0-9]{32}|(\{|\()?[A-Fa-f0-9]{8}-([A-Fa-f0-9]{4}-){3}[A-Fa-f0-9]{12}(\}|\))? This type is used by other XML schema attributes or elements that will
     *  hold a universal unique identifier (UUID), commonly known as either a globally unique identifier (GUID) or UUID. The regular expression defined limits the contents of an attribute to either a
     *  single 32-digit hexadecimal string or a 32-digit hex string patterned as [8]-[4]-[4]-[4]-[12] digits.
     */
    protected ?string $ServiceAgentUuid;

    public function getMerchantUuid(): ?string
    {
        return $this->MerchantUuid;
    }

    public function withMerchantUuid(?string $MerchantUuid): static
    {
        $new = clone $this;
        $new->MerchantUuid = $MerchantUuid;

        return $new;
    }

    public function getMerchantAliasId(): ?string
    {
        return $this->MerchantAliasId;
    }

    public function withMerchantAliasId(?string $MerchantAliasId): static
    {
        $new = clone $this;
        $new->MerchantAliasId = $MerchantAliasId;

        return $new;
    }

    public function getCashRegisterId(): ?string
    {
        return $this->CashRegisterId;
    }

    public function withCashRegisterId(?string $CashRegisterId): static
    {
        $new = clone $this;
        $new->CashRegisterId = $CashRegisterId;

        return $new;
    }

    public function getServiceAgentUuid(): ?string
    {
        return $this->ServiceAgentUuid;
    }

    public function withServiceAgentUuid(?string $ServiceAgentUuid): static
    {
        $new = clone $this;
        $new->ServiceAgentUuid = $ServiceAgentUuid;

        return $new;
    }
}
