<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use function Psl\Type\instance_of;
use function Psl\Type\union;

/**
 * @template-implements Enum<TransactionStatus::*>
 * @template-implements Comparable<TransactionStatus>
 * @template-implements Equality<TransactionStatus>
 */
final class TransactionStatus implements Enum, Comparable, Equality
{
    /** @use ComparableToEquality<TransactionStatus> */
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

    public function __construct(
        private readonly string $status
    ) {
        union(...array_map('Psl\Type\literal_scalar', self::all()))->assert($status);
    }

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

    public function compare($other): int
    {
        instance_of(self::class)->assert($other);

        return $this->status <=> $other->status;
    }
}
