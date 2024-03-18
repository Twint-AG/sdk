<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use Twint\Sdk\Assertion;
use Twint\Sdk\Exception\AssertionFailed;

/**
 * @template-implements Comparable<self>
 * @template-implements Equality<self>
 */
final class Url implements Comparable, Equality
{
    /** @use ComparableToEquality<self> */
    use ComparableToEquality;

    /**
     * @throws AssertionFailed
     */
    public function __construct(
        private readonly string $url
    ) {
        Assertion::url($url, 'URL "%s" is not valid');
    }

    public function __toString(): string
    {
        return $this->url;
    }

    /**
     * @throws AssertionFailed
     */
    public function compare($other): int
    {
        Assertion::isInstanceOf($other, self::class);

        return $this->url <=> $other->url;
    }
}
