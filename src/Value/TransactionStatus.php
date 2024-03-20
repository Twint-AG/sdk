<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use Twint\Sdk\Assertion;
use Twint\Sdk\Exception\AssertionFailed;

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

    /**
     * @throws AssertionFailed
     */
    public function __construct(
        private readonly string $status
    ) {
        Assertion::choice($status, self::all(), '"%s" is not a valid transaction status. Supported: %s');
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

    /**
     * @throws AssertionFailed
     */
    public function compare($other): int
    {
        Assertion::isInstanceOf($other, self::class);

        return $this->status <=> $other->status;
    }
}
