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
final class Url implements Stringable, Value
{
    /** @use ComparableToEquality<self> */
    use ComparableToEquality;

    /**
     * @param non-empty-string $url
     */
    public function __construct(
        private readonly string $url
    ) {
        invariant(filter_var($url, FILTER_VALIDATE_URL) !== false, 'URL "%s" is not valid', $url);
    }

    /**
     * @return non-empty-string
     */
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

    public function withQueryParameter(string $name, string $value): self
    {
        $separator = str_contains($this->url, '?') ? '&' : '?';

        return new self($this->url . $separator . urlencode($name) . '=' . urlencode($value));
    }

    /**
     * @return non-empty-string
     */
    #[Override]
    public function jsonSerialize(): string
    {
        return $this->url;
    }
}
