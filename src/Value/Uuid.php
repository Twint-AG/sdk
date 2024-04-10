<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use function Psl\invariant;
use function Psl\Regex\matches;
use function Psl\Type\instance_of;

/**
 * @template-implements Comparable<self>
 * @template-implements Equality<self>
 */
final class Uuid implements Comparable, Equality
{
    /** @use ComparableToEquality<self> */
    use ComparableToEquality;

    private readonly string $uuid;

    public function __construct(
        string $uuid
    ) {
        invariant(
            matches($uuid, '/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i'),
            'Invalid UUID "%s". Must be in the format "8-4-4-4-12"',
            $uuid
        );
        $this->uuid = strtolower($uuid);
    }

    public function __toString(): string
    {
        return $this->uuid;
    }

    public function compare($other): int
    {
        instance_of(self::class)->assert($other);

        return $this->uuid <=> $other->uuid;
    }
}
