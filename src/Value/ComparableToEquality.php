<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use function Psl\Type\instance_of;

/**
 * @template T of Equality
 * @phpstan-require-implements Comparable<T>
 */
trait ComparableToEquality
{
    /**
     * @param T $other
     */
    final public function equals(Equality $other): bool
    {
        instance_of(self::class)->assert($other);

        return $this->compare($other) === 0;
    }
}
