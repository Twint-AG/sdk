<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

class RequestHeaderElement
{
    /**
     * Base type: restriction of xs:string Pattern: [A-Fa-f0-9]{32}|(\{|\()?[A-Fa-f0-9]{8}-([A-Fa-f0-9]{4}-){3}[A-Fa-f0-9]{12}(\}|\))? This type is used by other XML schema attributes or elements that will
     *  hold a universal unique identifier (UUID), commonly known as either a globally unique identifier (GUID) or UUID. The regular expression defined limits the contents of an attribute to either a
     *  single 32-digit hexadecimal string or a 32-digit hex string patterned as [8]-[4]-[4]-[4]-[12] digits.
     */
    protected string $MessageId;

    protected string $ClientSoftwareName;

    protected string $ClientSoftwareVersion;

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

    public function getClientSoftwareName(): string
    {
        return $this->ClientSoftwareName;
    }

    public function withClientSoftwareName(string $ClientSoftwareName): static
    {
        $new = clone $this;
        $new->ClientSoftwareName = $ClientSoftwareName;

        return $new;
    }

    public function getClientSoftwareVersion(): string
    {
        return $this->ClientSoftwareVersion;
    }

    public function withClientSoftwareVersion(string $ClientSoftwareVersion): static
    {
        $new = clone $this;
        $new->ClientSoftwareVersion = $ClientSoftwareVersion;

        return $new;
    }
}
