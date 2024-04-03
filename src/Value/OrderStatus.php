<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use function Psl\Type\instance_of;
use function Psl\Type\union;

/**
 * @template-implements Enum<OrderStatus::*>
 * @template-implements Comparable<OrderStatus>
 * @template-implements Equality<OrderStatus>
 */
final class OrderStatus implements Enum, Comparable, Equality
{
    /** @use ComparableToEquality<self> */
    use ComparableToEquality;

    public const IN_PROGRESS = 'IN_PROGRESS';

    public const FAILURE = 'FAILURE';

    public const SUCCESS = 'SUCCESS';

    public function __construct(
        private readonly string $status
    ) {
        union(...array_map('Psl\Type\literal_scalar', self::all()))->assert($status);
    }

    public static function IN_PROGRESS(): self
    {
        return new self(self::IN_PROGRESS);
    }

    public static function FAILURE(): self
    {
        return new self(self::FAILURE);
    }

    public static function SUCCESS(): self
    {
        return new self(self::SUCCESS);
    }

    public static function all(): array
    {
        return [self::IN_PROGRESS, self::FAILURE, self::SUCCESS];
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
