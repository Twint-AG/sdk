<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use AllowDynamicProperties;

#[AllowDynamicProperties]
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

    /**
     * @param string $MessageId
     * @return RequestHeaderType
     */
    public function withMessageId($MessageId)
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

    /**
     * @param string $ClientSoftwareName
     * @return RequestHeaderType
     */
    public function withClientSoftwareName($ClientSoftwareName)
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

    /**
     * @param string $ClientSoftwareVersion
     * @return RequestHeaderType
     */
    public function withClientSoftwareVersion($ClientSoftwareVersion)
    {
        $new = clone $this;
        $new->ClientSoftwareVersion = $ClientSoftwareVersion;

        return $new;
    }
}
