<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use DateTimeInterface;

final class TimeBasedDataType
{
    /**
     * @var string
     */
    private $MessageTypeId;

    /**
     * @var DateTimeInterface
     */
    private $StartTimestamp;

    /**
     * @var DateTimeInterface
     */
    private $EndTimestamp;

    /**
     * @return string
     */
    public function getMessageTypeId()
    {
        return $this->MessageTypeId;
    }

    /**
     * @param string $MessageTypeId
     * @return TimeBasedDataType
     */
    public function withMessageTypeId($MessageTypeId)
    {
        $new = clone $this;
        $new->MessageTypeId = $MessageTypeId;

        return $new;
    }

    /**
     * @return DateTimeInterface
     */
    public function getStartTimestamp()
    {
        return $this->StartTimestamp;
    }

    /**
     * @param DateTimeInterface $StartTimestamp
     * @return TimeBasedDataType
     */
    public function withStartTimestamp($StartTimestamp)
    {
        $new = clone $this;
        $new->StartTimestamp = $StartTimestamp;

        return $new;
    }

    /**
     * @return DateTimeInterface
     */
    public function getEndTimestamp()
    {
        return $this->EndTimestamp;
    }

    /**
     * @param DateTimeInterface $EndTimestamp
     * @return TimeBasedDataType
     */
    public function withEndTimestamp($EndTimestamp)
    {
        $new = clone $this;
        $new->EndTimestamp = $EndTimestamp;

        return $new;
    }
}
