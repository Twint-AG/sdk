<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

/**
 * @template T of object
 */
interface Comparable
{
    /**
     * @param T $other
     * @return -1|0|1
     */
    public function compare($other): int;
}
