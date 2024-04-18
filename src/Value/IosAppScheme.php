<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use Override;
use function Psl\invariant;
use function Psl\Regex\matches;

/**
 * @template-implements Comparable<self>
 * @implements Equality<self>
 */
final class IosAppScheme implements Equality, Comparable
{
    /**
     * @use ComparableToEquality<self>
     */
    use ComparableToEquality;

    /**
     * @param non-empty-string $scheme
     * @param non-empty-string $displayName
     */
    public function __construct(
        private readonly string $scheme,
        private readonly string $displayName
    ) {
        invariant(matches($scheme, '@^twint-issuer\d+://@'), 'Scheme "%s" is not valid', $scheme);
    }

    /**
     * @return non-empty-string
     */
    public function scheme(): string
    {
        return $this->scheme;
    }

    /**
     * @return non-empty-string
     */
    public function displayName(): string
    {
        return $this->displayName;
    }

    #[Override]
    public function compare($other): int
    {
        return $this->scheme <=> $other->scheme;
    }
}
