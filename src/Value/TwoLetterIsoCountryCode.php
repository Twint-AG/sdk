<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use Override;
use function Psl\invariant;
use function Psl\Type\instance_of;

/**
 * @template-implements Value<TwoLetterIsoCountryCode>
 */
final class TwoLetterIsoCountryCode implements Value
{
    /**
     * @use ComparableToEquality<self>
     */
    use ComparableToEquality;

    public function __construct(
        private readonly string $code
    ) {
        invariant(strlen($code) === 2, 'Country code must be exactly 2 characters long');
    }

    #[Override]
    public function __toString(): string
    {
        return $this->code;
    }

    #[Override]
    public function compare($other): int
    {
        instance_of(self::class)->assert($other);

        return $this->code <=> $other->code;
    }

    #[Override]
    public function jsonSerialize(): mixed
    {
        return $this->code;
    }
}
