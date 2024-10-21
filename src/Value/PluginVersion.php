<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use Override;
use Stringable;
use function Psl\invariant;
use function Psl\Type\instance_of;

/**
 * @template-implements Value<self>
 */
final class PluginVersion implements Value, Stringable
{
    /** @use ComparableToEquality<self> */
    use ComparableToEquality;

    /**
     * @param non-empty-string $version
     */
    public function __construct(
        private readonly string $version
    ) {
        invariant(ctype_graph($version), 'Platform version must be a non-empty string of printable characters');
    }

    /**
     * @return non-empty-string
     */
    #[Override]
    public function __toString(): string
    {
        return $this->version;
    }

    #[Override]
    public function compare($other): int
    {
        instance_of(self::class)->assert($other);
        return $this->version <=> $other->version;
    }

    /**
     * @return non-empty-string
     */
    #[Override]
    public function jsonSerialize(): string
    {
        return $this->version;
    }
}
