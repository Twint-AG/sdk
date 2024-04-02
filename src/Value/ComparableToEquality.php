<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use function Psl\Type\instance_of;

/**
 * @template T of object
 * @phpstan-require-implements Comparable<T>
 */
trait ComparableToEquality
{
    /**
     * @param T $other
     */
    public function equals($other): bool
    {
        instance_of(self::class)->assert($other);

        return $this->compare($other) === 0;
    }
}
