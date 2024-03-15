<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use Twint\Sdk\Assertion;
use Twint\Sdk\Exception\AssertionFailed;

/**
 * @template-implements Comparable<self>
 * @template-implements Equality<self>
 */
final class MerchantId implements Comparable, Equality
{
    /** @use ComparableToEquality<self> */
    use ComparableToEquality;

    public function __construct(
        private readonly Uuid $uuid
    ) {
    }

    /**
     * @throws AssertionFailed
     */
    public static function fromString(string $uuid): self
    {
        return new self(new Uuid($uuid));
    }

    public function __toString(): string
    {
        return (string) $this->uuid;
    }

    /**
     * @throws AssertionFailed
     */
    public function compare($other): int
    {
        Assertion::isObject($other, self::class);

        return $this->uuid->compare($other->uuid);
    }
}
