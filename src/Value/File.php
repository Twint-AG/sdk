<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use function Psl\Filesystem\canonicalize;
use function Psl\Filesystem\is_readable;
use function Psl\invariant;
use function Psl\Type\instance_of;

/**
 * @template-implements Comparable<self>
 * @template-implements Equality<self>
 */
final class File implements Comparable, Equality
{
    /** @use ComparableToEquality<self> */
    use ComparableToEquality;

    /**
     * @var non-empty-string
     */
    private readonly string $path;

    /**
     * @param non-empty-string $path
     */
    public function __construct(
        string $path
    ) {
        invariant(is_readable($path), 'File "%s" is not readable', $path);
        $canonicalPath = canonicalize($path);
        invariant(is_string($canonicalPath), 'Cannot canonicalize path "%s"', $path);
        $this->path = $canonicalPath;
    }

    /**
     * @return non-empty-string
     */
    public function __toString(): string
    {
        return $this->path;
    }

    public function compare($other): int
    {
        instance_of(self::class)->assert($other);

        return strcmp($this->path, $other->path);
    }
}
