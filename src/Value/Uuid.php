<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use Twint\Sdk\Assertion;
use Twint\Sdk\Exception\AssertionFailed;

final class Uuid
{
    /**
     * @throws AssertionFailed
     */
    public function __construct(
        private string $id
    ) {
        Assertion::uuid($id);
        Assertion::length($id, 36, 'UUID "%s" has incorrect length. Must be exactly %d characters, got %d');
        $this->id = strtolower($id);
    }

    public function __toString(): string
    {
        return $this->id;
    }
}
