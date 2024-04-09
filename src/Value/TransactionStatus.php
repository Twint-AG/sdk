<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use function Psl\Type\instance_of;
use function Psl\Type\union;

/**
 * @template-implements Enum<self::*>
 * @template-implements Comparable<self>
 * @template-implements Equality<self>
 */
final class TransactionStatus implements Enum, Comparable, Equality
{
    /** @use ComparableToEquality<self> */
    use ComparableToEquality;

    public const ORDER_OK = 'ORDER_OK';

    public const ORDER_PARTIAL_OK = 'ORDER_PARTIAL_OK';

    public const ORDER_RECEIVED = 'ORDER_RECEIVED';

    public const ORDER_PENDING = 'ORDER_PENDING';

    public const ORDER_CONFIRMATION_PENDING = 'ORDER_CONFIRMATION_PENDING';

    public const GENERAL_ERROR = 'GENERAL_ERROR';

    public const CLIENT_TIMEOUT = 'CLIENT_TIMEOUT';

    public const MERCHANT_ABORT = 'MERCHANT_ABORT';

    public const CLIENT_ABORT = 'CLIENT_ABORT';

    /**
     * @param self::* $status
     */
    public function __construct(
        private readonly string $status
    ) {
        self::assert($status);
    }

    public static function fromString(string $status): self
    {
        return new self(self::assert($status));
    }

    public static function ORDER_OK(): self
    {
        return new self(self::ORDER_OK);
    }

    public static function ORDER_PARTIAL_OK(): self
    {
        return new self(self::ORDER_PARTIAL_OK);
    }

    public static function ORDER_RECEIVED(): self
    {
        return new self(self::ORDER_RECEIVED);
    }

    public static function ORDER_PENDING(): self
    {
        return new self(self::ORDER_PENDING);
    }

    public static function ORDER_CONFIRMATION_PENDING(): self
    {
        return new self(self::ORDER_CONFIRMATION_PENDING);
    }

    public static function GENERAL_ERROR(): self
    {
        return new self(self::GENERAL_ERROR);
    }

    public static function CLIENT_TIMEOUT(): self
    {
        return new self(self::CLIENT_TIMEOUT);
    }

    public static function MERCHANT_ABORT(): self
    {
        return new self(self::MERCHANT_ABORT);
    }

    public static function CLIENT_ABORT(): self
    {
        return new self(self::CLIENT_ABORT);
    }

    /**
     * @return list<self::*>
     */
    public static function all(): array
    {
        return [
            self::ORDER_OK,
            self::ORDER_PARTIAL_OK,
            self::ORDER_RECEIVED,
            self::ORDER_PENDING,
            self::ORDER_CONFIRMATION_PENDING,
            self::GENERAL_ERROR,
            self::CLIENT_TIMEOUT,
            self::MERCHANT_ABORT,
            self::CLIENT_ABORT,
        ];
    }

    public function __toString(): string
    {
        return $this->status;
    }

    /**
     * @return self::*
     */
    private static function assert(string $status): string
    {
        /** @var self::* */
        return union(...array_map('Psl\Type\literal_scalar', self::all()))->assert($status);
    }

    public function compare($other): int
    {
        instance_of(self::class)->assert($other);

        return $this->status <=> $other->status;
    }
}
