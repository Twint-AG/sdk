<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use Stringable;

/**
 * @template T
 */
interface Enum extends Stringable
{
    /**
     * @return list<T>
     */
    public static function all(): array;
}
