<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use Twint\Sdk\Assertion;
use Twint\Sdk\Exception\AssertionFailed;

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
     * @throws AssertionFailed
     */
    public function __construct(
        string $path
    ) {
        Assertion::readable($path);
        $path = realpath($path);
        Assertion::string($path, 'Real path could be extracted');
        $this->path = $path;
    }

    /**
     * @return non-empty-string
     */
    public function __toString(): string
    {
        return $this->path;
    }

    /**
     * @throws AssertionFailed
     */
    public function compare($other): int
    {
        Assertion::isInstanceOf($other, self::class);

        return strcmp($this->path, $other->path);
    }
}
