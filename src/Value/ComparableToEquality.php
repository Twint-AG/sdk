<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use Twint\Sdk\Assertion;
use Twint\Sdk\Exception\AssertionFailed;

/**
 * @template T of object
 * @phpstan-require-implements Comparable<T>
 */
trait ComparableToEquality
{
    /**
     * @param T $other
     * @throws AssertionFailed
     */
    public function equals($other): bool
    {
        Assertion::isInstanceOf($other, self::class);

        return $this->compare($other) === 0;
    }
}
