<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use Override;
use Stringable;
use function Psl\Type\instance_of;
use function Psl\Type\uint;

/**
 * @phpstan-type UnsignedInt int<0, max>
 * @template-implements Value<self>
 * @template-implements PairingToken<UnsignedInt>
 */
final class NumericPairingToken implements Stringable, Value, PairingToken
{
    /** @use ComparableToEquality<self> */
    use ComparableToEquality;

    /**
     * @param UnsignedInt $token
     */
    public function __construct(
        private readonly int $token,
    ) {
        uint()->assert($token);
    }

    public static function fromString(string $token): self
    {
        return new self(uint()->coerce($token));
    }

    #[Override]
    public function __toString(): string
    {
        return (string) $this->token;
    }

    #[Override]
    public function token()
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
    public function jsonSerialize(): int
    {
        return $this->token;
    }
}
