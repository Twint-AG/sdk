<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use Twint\Sdk\Assertion;

final class Uuid
{
    public function __construct(
        private string $id
    ) {
        Assertion::uuid($id);
        Assertion::length($id, 36);
        $this->id = strtolower($id);
    }

    public function __toString(): string
    {
        return $this->id;
    }
}
