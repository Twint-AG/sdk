<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use Twint\Sdk\Util\Type;
use function Psl\Type\instance_of;

/**
 * @template-implements Enum<self::*>
 * @template-implements Comparable<self>
 * @template-implements Equality<self>
 */
final class PairingStatus implements Enum, Comparable, Equality
{
    /** @use ComparableToEquality<self> */
    use ComparableToEquality;

    public const NO_PAIRING = 'NO_PAIRING';

    public const PAIRING_IN_PROGRESS = 'PAIRING_IN_PROGRESS';

    public const PAIRING_ACTIVE = 'PAIRING_ACTIVE';

    /**
     * @param self::* $status
     */
    public function __construct(
        private readonly string $status
    ) {
        Type::unionOfLiterals(...self::all())->assert($status);
    }

    public static function fromString(string $status): self
    {
        /** @var self::* $status */
        $status = Type::unionOfLiterals(...self::all())->assert($status);

        return new self($status);
    }

    public static function all(): array
    {
        return [self::NO_PAIRING, self::PAIRING_IN_PROGRESS, self::PAIRING_ACTIVE];
    }

    public static function PAIRING_IN_PROGRESS(): self
    {
        return new self(self::PAIRING_IN_PROGRESS);
    }

    public static function NO_PAIRING(): self
    {
        return new self(self::NO_PAIRING);
    }

    public static function PAIRING_ACTIVE(): self
    {
        return new self(self::PAIRING_ACTIVE);
    }

    public function __toString(): string
    {
        return $this->status;
    }

    public function compare($other): int
    {
        instance_of(self::class)->assert($other);

        return $this->status <=> $other->status;
    }
}
