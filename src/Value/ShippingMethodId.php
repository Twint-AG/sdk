<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use Override;
use Stringable;
use function Psl\Type\instance_of;
use function Psl\Type\non_empty_string;

/**
 * @template-implements Value<self>
 */
final class ShippingMethodId implements Value, Stringable
{
    /**
     * @use ComparableToEquality<self>
     */
    use ComparableToEquality;

    public function __construct(
        private readonly string $id
    ) {
        non_empty_string()->assert($id);
    }

    #[Override]
    public function __toString(): string
    {
        return $this->id;
    }

    #[Override]
    public function compare($other): int
    {
        instance_of(self::class)->assert($other);

        return $this->id <=> $other->id;
    }

    #[Override]
    public function jsonSerialize(): string
    {
        return $this->id;
    }
}
