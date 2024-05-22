<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use Override;
use function Psl\Type\instance_of;
use function Psl\Type\uint;

/**
 * @template-implements Value<self>
 */
final class PairingToken implements Value
{
    /** @use ComparableToEquality<self> */
    use ComparableToEquality;

    /**
     * @param int<0, max> $token
     */
    public function __construct(
        private readonly int $token,
    ) {
        uint()->assert($token);
    }

    #[Override]
    public function __toString(): string
    {
        return (string) $this->token;
    }

    public function token(): int
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
