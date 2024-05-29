<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

/**
 * @template T of self
 * @phpstan-type ComparisonResult = -1|0|1
 */
interface Comparable
{
    /**
     * @param T $other
     * @return ComparisonResult
     */
    public function compare($other): int;
}
