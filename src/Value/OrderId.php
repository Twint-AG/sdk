<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use Override;
use function Psl\Type\instance_of;

/**
 * @template-implements Comparable<self>
 * @template-implements Equality<self>
 */
final class OrderId implements Comparable, Equality
{
    /** @use ComparableToEquality<self> */
    use ComparableToEquality;

    public function __construct(
        private readonly Uuid $uuid
    ) {
    }

    public static function fromString(string $uuid): self
    {
        return new self(new Uuid($uuid));
    }

    #[Override]
    public function __toString(): string
    {
        return (string) $this->uuid;
    }

    #[Override]
    public function compare($other): int
    {
        instance_of(self::class)->assert($other);

        return $this->uuid->compare($other->uuid);
    }
}
