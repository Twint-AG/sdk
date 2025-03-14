<?php

declare(strict_types=1);

namespace Twint\Sdk\Tools\PHPUnit;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD | Attribute::TARGET_CLASS)]
final class Retry
{
    /**
     * @param non-zero-int $times
     */
    public function __construct(
        public readonly int $times
    ) {
    }
}
