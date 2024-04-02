<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use function Psl\invariant;
use function Psl\Type\instance_of;

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
     * @param non-empty-string $value
     */
    public function __construct(
        private readonly string $value
    ) {
        invariant(
            strlen($value) <= self::MAX_LENGTH,
            'Transaction reference "%s" is too long. Must be %d characters or less, got %d',
            $value,
            self::MAX_LENGTH,
            strlen($value)
        );
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function compare($other): int
    {
        instance_of(self::class)->assert($other);

        return $this->value <=> $other->value;
    }
}
