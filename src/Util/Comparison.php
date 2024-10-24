<?php

declare(strict_types=1);

namespace Twint\Sdk\Util;

use Twint\Sdk\Value\Comparable;

/**
 * @phpstan-import-type ComparisonResult from Comparable
 */
final class Comparison
{
    /**
     * Compares pairs of Comparable objects.
     *
     * Returns the first non-zero result of the comparison or 0 if all pairs are equal.
     *
     * @template T of Comparable|scalar|null
     * @param list<array{T, T}> $pairs
     * @return ComparisonResult
     */
    public static function comparePairs(array $pairs): int
    {
        foreach ($pairs as [$left, $right]) {
            $result = !$left instanceof Comparable || !$right instanceof Comparable
                ? $left <=> $right
                : $left->compare($right);

            if ($result !== 0) {
                return $result;
            }
        }

        return 0;
    }
}
