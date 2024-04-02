<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use function Psl\Type\instance_of;
use function Psl\Type\union;

/**
 * @template-implements Enum<OrderKind::*>
 * @template-implements Comparable<OrderKind>
 * @template-implements Equality<OrderKind>
 */
final class OrderKind implements Enum, Comparable, Equality
{
    /** @use ComparableToEquality<OrderKind> */
    use ComparableToEquality;

    public const PAYMENT_IMMEDIATE = 'PAYMENT_IMMEDIATE';

    public const PAYMENT_DEFERRED = 'PAYMENT_DEFERRED';

    public const PAYMENT_RECURRING = 'PAYMENT_RECURRING';

    public const REVERSAL = 'REVERSAL';

    public const CREDIT = 'CREDIT';

    /**
     * @param OrderKind::* $kind
     */
    public function __construct(
        private readonly string $kind
    ) {
        union(...array_map('Psl\Type\literal_scalar', self::all()))->assert($kind);
    }

    public static function PAYMENT_IMMEDIATE(): self
    {
        return new self(self::PAYMENT_IMMEDIATE);
    }

    public static function PAYMENT_DEFERRED(): self
    {
        return new self(self::PAYMENT_DEFERRED);
    }

    public static function PAYMENT_RECURRING(): self
    {
        return new self(self::PAYMENT_RECURRING);
    }

    public static function REVERSAL(): self
    {
        return new self(self::REVERSAL);
    }

    public static function CREDIT(): self
    {
        return new self(self::CREDIT);
    }

    public static function all(): array
    {
        return [
            self::PAYMENT_IMMEDIATE,
            self::PAYMENT_DEFERRED,
            self::PAYMENT_RECURRING,
            self::REVERSAL,
            self::CREDIT,
        ];
    }

    /**
     * @return OrderKind::*
     */
    public function __toString(): string
    {
        return $this->kind;
    }

    public function compare($other): int
    {
        instance_of(self::class)->assert($other);

        return $this->kind <=> $other->kind;
    }
}
