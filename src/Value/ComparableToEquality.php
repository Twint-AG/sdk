<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use Override;
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
    #[Override]
    final public function equals(Equality $other): bool
    {
        instance_of(self::class)->assert($other);

        return $this->compare($other) === 0;
    }
}
