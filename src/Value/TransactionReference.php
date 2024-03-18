<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use Twint\Sdk\Assertion;
use Twint\Sdk\Exception\AssertionFailed;

/**
 * @template-implements Comparable<self>
 * @template-implements Equality<self>
 */
final class TransactionReference implements Comparable, Equality
{
    /** @use ComparableToEquality<self> */

    use ComparableToEquality;

    private const MAX_LENGTH = 50;

    /**
     * @throws AssertionFailed
     */
    public function __construct(
        private readonly string $value
    ) {
        Assertion::maxLength(
            $value,
            self::MAX_LENGTH,
            'Transaction reference "%s" is too long. Must be %d characters or less, got %d'
        );
    }

    public function __toString(): string
    {
        return $this->value;
    }

    /**
     * @throws AssertionFailed
     */
    public function compare($other): int
    {
        Assertion::isInstanceOf($other, self::class);

        return $this->value <=> $other->value;
    }
}
