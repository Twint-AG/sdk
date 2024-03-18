<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use Twint\Sdk\Assertion;
use Twint\Sdk\Exception\AssertionFailed;

final class File
{
    /**
     * @throws AssertionFailed
     */
    public function __construct(
        private readonly string $path
    ) {
        Assertion::readable($path);
    }

    public function __toString(): string
    {
        return $this->path;
    }
}
