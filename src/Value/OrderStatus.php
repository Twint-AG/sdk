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
final class OrderStatus implements Enum, Comparable, Equality
{
    /** @use ComparableToEquality<self> */
    use ComparableToEquality;

    public const IN_PROGRESS = 'IN_PROGRESS';

    public const FAILURE = 'FAILURE';

    public const SUCCESS = 'SUCCESS';

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
