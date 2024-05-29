<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use Override;
use Stringable;
use function Psl\Type\instance_of;

/**
 * @template-implements Value<self>
 */
final class PhoneNumber implements Value, Stringable
{
    /**
     * @use ComparableToEquality<self>
     */
    use ComparableToEquality;

    public function __construct(
        private readonly string $phoneNumber
    ) {
    }

    #[Override]
    public function __toString(): string
    {
        return $this->phoneNumber;
    }

    #[Override]
    public function compare($other): int
    {
        instance_of(self::class)->assert($other);

        return $this->phoneNumber <=> $other->phoneNumber;
    }

    #[Override]
    public function jsonSerialize(): string
    {
        return $this->phoneNumber;
    }
}
