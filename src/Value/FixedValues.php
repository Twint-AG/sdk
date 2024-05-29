<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

/**
 * @template T
 */
interface FixedValues
{
    /**
     * @return list<T>
     */
    public static function all(): array;
}
