<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use Twint\Sdk\Exception\AssertionFailed;

final class OrderId
{
    public function __construct(
        private readonly Uuid $uuid
    ) {
    }

    /**
     * @throws AssertionFailed
     */
    public static function fromString(string $uuid): self
    {
        return new self(new Uuid($uuid));
    }

    public function __toString(): string
    {
        return (string) $this->uuid;
    }
}
