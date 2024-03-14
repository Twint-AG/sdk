<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use DateTimeInterface;

class TimeBasedDataType
{
    protected string $MessageTypeId;

    protected DateTimeInterface $StartTimestamp;

    protected DateTimeInterface $EndTimestamp;

    public function getMessageTypeId(): string
    {
        return $this->MessageTypeId;
    }

    public function withMessageTypeId(string $MessageTypeId): static
    {
        $new = clone $this;
        $new->MessageTypeId = $MessageTypeId;

        return $new;
    }

    public function getStartTimestamp(): DateTimeInterface
    {
        return $this->StartTimestamp;
    }

    public function withStartTimestamp(DateTimeInterface $StartTimestamp): static
    {
        $new = clone $this;
        $new->StartTimestamp = $StartTimestamp;

        return $new;
    }

    public function getEndTimestamp(): DateTimeInterface
    {
        return $this->EndTimestamp;
    }

    public function withEndTimestamp(DateTimeInterface $EndTimestamp): static
    {
        $new = clone $this;
        $new->EndTimestamp = $EndTimestamp;

        return $new;
    }
}
