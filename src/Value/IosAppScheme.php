<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use Twint\Sdk\Assertion;
use Twint\Sdk\Exception\AssertionFailed;

final class IosAppScheme
{
    /**
     * @param non-empty-string $scheme
     * @param non-empty-string $displayName
     * @throws AssertionFailed
     */
    public function __construct(
        private readonly string $scheme,
        private readonly string $displayName
    ) {
        Assertion::regex($scheme, '@^twint-issuer\d+://@', 'Scheme "%s" is not valid');
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
