<?php

declare(strict_types=1);

use Twint\Sdk\Value\Comparable;

if (PHP_VERSION_ID < 80200) {
    #[Attribute(Attribute::TARGET_PARAMETER)]
    final class SensitiveParameter
    {
    }
}

/**
 * @template T of Comparable
 * @param list<array{T, T}> $pairs
 * @return 1|-1|0
 */
function compareAll(array $pairs): int
{
    foreach ($pairs as [$left, $right]) {
        $result = $left->compare($right);

        if ($result !== 0) {
            return $result;
        }
    }

    return 0;
}
