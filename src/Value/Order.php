<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use Twint\Sdk\Assertion;
use Twint\Sdk\Exception\AssertionFailed;
use Twint\Sdk\Util\Comparison;

/**
 * @template-implements Comparable<self>
 * @template-implements Equality<self>
 */
final class Order implements Comparable, Equality
{
    /** @use ComparableToEquality<self> */
    use ComparableToEquality;

    public function __construct(
        private readonly OrderId $id,
        private readonly OrderStatus $status,
        private readonly TransactionStatus $transactionStatus,
        private readonly TransactionReference $transactionReference,
    ) {
    }

    public function id(): OrderId
    {
        return $this->id;
    }

    public function status(): OrderStatus
    {
        return $this->status;
    }

    public function transactionStatus(): TransactionStatus
    {
        return $this->transactionStatus;
    }

    public function transactionReference(): TransactionReference
    {
        return $this->transactionReference;
    }

    /**
     * @throws AssertionFailed
     */
    public function compare($other): int
    {
        Assertion::isInstanceOf($other, self::class);

        return Comparison::comparePairs([
            [$this->id, $other->id],
            [$this->status, $other->status],
            [$this->transactionStatus, $other->transactionStatus],
            [$this->transactionReference, $other->transactionReference],
        ]);
    }
}
