<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use Override;
use function Psl\Type\instance_of;
use function Psl\Type\non_empty_string;

/**
 * @template-implements Value<self>
 */
final class AlphanumericPairingToken implements Value
{
    /** @use ComparableToEquality<self> */
    use ComparableToEquality;

    /**
     * @param non-empty-string $token
     */
    public function __construct(
        private readonly string $token,
    ) {
        non_empty_string()->assert($token);
    }

    public static function fromString(string $token): self
    {
        return new self(non_empty_string()->assert($token));
    }

    #[Override]
    public function __toString(): string
    {
        return $this->token;
    }

    /**
     * @return non-empty-string
     */
    public function token(): string
    {
        return $this->token;
    }

    #[Override]
    public function compare($other): int
    {
        instance_of(self::class)->assert($other);

        return $this->token <=> $other->token;
    }

    #[Override]
    public function jsonSerialize(): string
    {
        return $this->token;
    }
}
