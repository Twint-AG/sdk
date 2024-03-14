<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

class ResponseHeaderType
{
    /**
     * Base type: restriction of xs:string Pattern: [A-Fa-f0-9]{32}|(\{|\()?[A-Fa-f0-9]{8}-([A-Fa-f0-9]{4}-){3}[A-Fa-f0-9]{12}(\}|\))? This type is used by other XML schema attributes or elements that will
     *  hold a universal unique identifier (UUID), commonly known as either a globally unique identifier (GUID) or UUID. The regular expression defined limits the contents of an attribute to either a
     *  single 32-digit hexadecimal string or a 32-digit hex string patterned as [8]-[4]-[4]-[4]-[12] digits.
     */
    protected string $MessageId;

    public function getMessageId(): string
    {
        return $this->MessageId;
    }

    public function withMessageId(string $MessageId): static
    {
        $new = clone $this;
        $new->MessageId = $MessageId;

        return $new;
    }
}
