<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use Override;
use function Psl\invariant;
use function Psl\Regex\matches;
use function Psl\Type\instance_of;

/**
 * @template-implements Value<self>
 */
final class IosAppScheme implements Value
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
        instance_of(self::class)->assert($other);

        return $this->scheme <=> $other->scheme;
    }

    /**
     * @return array{scheme: non-empty-string, displayName: non-empty-string}
     */
    #[Override]
    public function jsonSerialize(): array
    {
        return [
            'scheme' => $this->scheme,
            'displayName' => $this->displayName,
        ];
    }
}
