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
final class Email implements Value, Stringable
{
    /**
     * @use ComparableToEquality<self>
     */
    use ComparableToEquality;

    private readonly string $email;

    public function __construct(
        string $email
    ) {
        invariant(filter_var($email, FILTER_VALIDATE_EMAIL) !== false, 'Invalid email address: %s', $email);
        $this->email = strtolower($email);
    }

    #[Override]
    public function __toString(): string
    {
        return $this->email;
    }

    #[Override]
    public function compare($other): int
    {
        instance_of(self::class)->assert($other);

        return $this->email <=> $other->email;
    }

    #[Override]
    public function jsonSerialize(): string
    {
        return $this->email;
    }
}
