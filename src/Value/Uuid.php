<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use Twint\Sdk\Assertion;
use Twint\Sdk\Exception\AssertionFailed;

/**
 * @template-implements Comparable<self>
 * @template-implements Equality<self>
 */
final class Uuid implements Comparable, Equality
{
    /** @use ComparableToEquality<self> */
    use ComparableToEquality;

    /**
     * @throws AssertionFailed
     */
    public function __construct(
        private string $uuid
    ) {
        Assertion::uuid($uuid);
        Assertion::length($uuid, 36, 'UUID "%s" has incorrect length. Must be exactly %d characters, got %d');
        $this->uuid = strtolower($uuid);
    }

    public function __toString(): string
    {
        return $this->uuid;
    }

    /**
     * @throws AssertionFailed
     */
    public function compare($other): int
    {
        Assertion::isObject($other, self::class);

        return $this->uuid <=> $other->uuid;
    }
}
