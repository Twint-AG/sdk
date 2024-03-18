<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use Twint\Sdk\Assertion;
use Twint\Sdk\Exception\AssertionFailed;

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
     * @throws AssertionFailed
     */
    public function __construct(
        private readonly string $kind
    ) {
        Assertion::choice($kind, self::all(), '"%s" is not a order kind. Supported: %s');
    }

    /**
     * @throws AssertionFailed
     */
    public static function PAYMENT_IMMEDIATE(): self
    {
        return new self(self::PAYMENT_IMMEDIATE);
    }

    /**
     * @throws AssertionFailed
     */
    public static function PAYMENT_DEFERRED(): self
    {
        return new self(self::PAYMENT_DEFERRED);
    }

    /**
     * @throws AssertionFailed
     */
    public static function PAYMENT_RECURRING(): self
    {
        return new self(self::PAYMENT_RECURRING);
    }

    /**
     * @throws AssertionFailed
     */
    public static function REVERSAL(): self
    {
        return new self(self::REVERSAL);
    }

    /**
     * @throws AssertionFailed
     */
    public static function CREDIT(): self
    {
        return new self(self::CREDIT);
    }

    public function __toString(): string
    {
        return $this->kind;
    }

    public function all(): array
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
     * @throws AssertionFailed
     */
    public function compare($other): int
    {
        Assertion::isInstanceOf($other, self::class);

        return $this->kind <=> $other->kind;
    }
}
