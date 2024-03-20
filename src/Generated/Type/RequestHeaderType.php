<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

final class RequestHeaderType
{
    /**
     * @var string
     */
    private $MessageId;

    /**
     * @var string
     */
    private $ClientSoftwareName;

    /**
     * @var string
     */
    private $ClientSoftwareVersion;

    /**
     * @return string
     */
    public function getMessageId()
    {
        return $this->MessageId;
    }

    public function withMessageId(string $MessageId): self
    {
        $new = clone $this;
        $new->MessageId = $MessageId;

        return $new;
    }

    /**
     * @return string
     */
    public function getClientSoftwareName()
    {
        return $this->ClientSoftwareName;
    }

    public function withClientSoftwareName(string $ClientSoftwareName): self
    {
        $new = clone $this;
        $new->ClientSoftwareName = $ClientSoftwareName;

        return $new;
    }

    /**
     * @return string
     */
    public function getClientSoftwareVersion()
    {
        return $this->ClientSoftwareVersion;
    }

    public function withClientSoftwareVersion(string $ClientSoftwareVersion): self
    {
        $new = clone $this;
        $new->ClientSoftwareVersion = $ClientSoftwareVersion;

        return $new;
    }
}
