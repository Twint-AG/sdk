<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

/**
 * @template T
 */
interface Enum
{
    public function __toString(): string;

    /**
     * @return list<T>
     */
    public function all(): array;
}
