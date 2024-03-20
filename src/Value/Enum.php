<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

/**
 * @template T
 */
interface Enum
{
    /**
     * @return list<T>
     */
    public static function all(): array;

    public function __toString(): string;
}
