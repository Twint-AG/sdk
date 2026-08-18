<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use DateTimeInterface;

class MessageHeaderType
{
    /**
     * Base type: restriction of xs:string Pattern: [A-Fa-f0-9]{32}|(\{|\()?[A-Fa-f0-9]{8}-([A-Fa-f0-9]{4}-){3}[A-Fa-f0-9]{12}(\}|\))? This type is used by other XML schema attributes or elements that will
     *  hold a universal unique identifier (UUID), commonly known as either a globally unique identifier (GUID) or UUID. The regular expression defined limits the contents of an attribute to either a
     *  single 32-digit hexadecimal string or a 32-digit hex string patterned as [8]-[4]-[4]-[4]-[12] digits.
     */
    protected string $ExchangeId;

    protected DateTimeInterface $MessageDateTime;

    public function getExchangeId(): string
    {
        return $this->ExchangeId;
    }

    public function withExchangeId(string $ExchangeId): static
    {
        $new = clone $this;
        $new->ExchangeId = $ExchangeId;

        return $new;
    }

    public function getMessageDateTime(): DateTimeInterface
    {
        return $this->MessageDateTime;
    }

    public function withMessageDateTime(DateTimeInterface $MessageDateTime): static
    {
        $new = clone $this;
        $new->MessageDateTime = $MessageDateTime;

        return $new;
    }
}
