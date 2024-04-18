<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use Override;
use function Psl\invariant;
use function Psl\Type\instance_of;
use function Psl\Type\non_empty_string;

/**
 * @template-implements Comparable<self>
 * @template-implements Equality<self>
 */
abstract class MerchantTransactionReference implements Comparable, Equality
{
    /** @use ComparableToEquality<self> */

    use ComparableToEquality;

    private const MAX_LENGTH = 50;

    /**
     * @param non-empty-string $value
     */
    final public function __construct(
        private readonly string $value
    ) {
        non_empty_string()->assert($value);
        invariant(
            strlen($value) <= self::MAX_LENGTH,
            'Transaction reference "%s" is too long. Must be %d characters or less, got %d',
            $value,
            self::MAX_LENGTH,
            strlen($value)
        );
    }

    /**
     * @return non-empty-string
     */
    #[Override]
    final public function __toString(): string
    {
        return $this->value;
    }

    #[Override]
    final public function compare($other): int
    {
        instance_of(self::class)->assert($other);

        return $this->value <=> $other->value;
    }
}
