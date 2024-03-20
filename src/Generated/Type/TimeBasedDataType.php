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

    public function withMessageTypeId(string $MessageTypeId): self
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

    public function withStartTimestamp(DateTimeInterface $StartTimestamp): self
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

    public function withEndTimestamp(DateTimeInterface $EndTimestamp): self
    {
        $new = clone $this;
        $new->EndTimestamp = $EndTimestamp;

        return $new;
    }
}
