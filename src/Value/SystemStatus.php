<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use function Psl\Type\instance_of;
use function Psl\Type\union;

/**
 * @template-implements Equality<self>
 * @template-implements Comparable<self>
 * @template-implements Enum<self::*>
 */
final class SystemStatus implements Comparable, Equality, Enum
{
    /** @use ComparableToEquality<self> */
    use ComparableToEquality;

    public const OK = 'OK';

    public const ERROR = 'ERROR';

    /**
     * @param self::* $status
     */
    public function __construct(
        private readonly string $status,
    ) {
        self::assert($status);
    }

    /**
     * @return self::*
     */
    public static function assert(string $status): string
    {
        /** @var self::* */
        return union(...array_map('Psl\Type\literal_scalar', self::all()))->assert($status);
    }

    public static function all(): array
    {
        return [self::OK, self::ERROR];
    }

    public static function OK(): self
    {
        return new self(self::OK);
    }

    public static function ERROR(): self
    {
        return new self(self::ERROR);
    }

    public function __toString(): string
    {
        return $this->status;
    }

    public function isOk(): bool
    {
        return $this->status === self::OK;
    }

    public function compare($other): int
    {
        instance_of(self::class)->assert($other);

        return $this->status <=> $other->status;
    }
}
