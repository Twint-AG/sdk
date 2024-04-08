<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use function Psl\Type\instance_of;
use function Psl\Type\uint;

/**
 * @template-implements Equality<self>
 * @template-implements Comparable<self>
 */
final class PairingToken implements Comparable, Equality
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

    public function __toString(): string
    {
        return (string) $this->token;
    }

    public function token(): int
    {
        return $this->token;
    }

    public function compare($other): int
    {
        instance_of(self::class)->assert($other);

        return $this->token <=> $other->token;
    }
}
