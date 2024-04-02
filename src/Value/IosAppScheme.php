<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use function Psl\invariant;
use function Psl\Regex\matches;

final class IosAppScheme
{
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
}
