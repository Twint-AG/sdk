<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use Override;
use function Psl\invariant;
use function Psl\Type\instance_of;

/**
 * @template-implements Value<self>
 */
final class Url implements Value
{
    /** @use ComparableToEquality<self> */
    use ComparableToEquality;

    public function __construct(
        private readonly string $url
    ) {
        invariant(filter_var($url, FILTER_VALIDATE_URL) !== false, 'URL "%s" is not valid', $url);
    }

    #[Override]
    public function __toString(): string
    {
        return $this->url;
    }

    #[Override]
    public function compare($other): int
    {
        instance_of(self::class)->assert($other);

        return $this->url <=> $other->url;
    }

    #[Override]
    public function jsonSerialize(): string
    {
        return $this->url;
    }
}
