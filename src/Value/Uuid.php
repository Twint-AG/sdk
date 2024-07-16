<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use Override;
use function Psl\invariant;
use function Psl\Regex\matches;
use function Psl\Type\instance_of;

/**
 * @template-implements Value<self>
 */
final class Uuid implements Value
{
    /** @use ComparableToEquality<self> */
    use ComparableToEquality;

    public const LENGTH = 36;

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

    #[Override]
    public function __toString(): string
    {
        return $this->uuid;
    }

    #[Override]
    public function compare($other): int
    {
        instance_of(self::class)->assert($other);

        return $this->uuid <=> $other->uuid;
    }

    #[Override]
    public function jsonSerialize(): string
    {
        return $this->uuid;
    }
}
