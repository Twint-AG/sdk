<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use function Psl\invariant;
use function Psl\Type\instance_of;

/**
 * @template-implements Comparable<self>
 * @template-implements Equality<self>
 */
final class Url implements Comparable, Equality
{
    /** @use ComparableToEquality<self> */
    use ComparableToEquality;

    public function __construct(
        private readonly string $url
    ) {
        invariant(filter_var($url, FILTER_VALIDATE_URL) !== false, 'URL "%s" is not valid', $url);
    }

    public function __toString(): string
    {
        return $this->url;
    }

    public function compare($other): int
    {
        instance_of(self::class)->assert($other);

        return $this->url <=> $other->url;
    }
}
