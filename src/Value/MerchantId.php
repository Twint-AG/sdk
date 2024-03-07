<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

final class MerchantId
{
    public function __construct(
        private Uuid $uuid
    ) {
    }

    public function __toString(): string
    {
        return (string) $this->uuid;
    }

    public static function fromString(string $uuid): self
    {
        return new self(new Uuid($uuid));
    }
}
