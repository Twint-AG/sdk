<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use Twint\Sdk\Util\Comparison;
use function Psl\Type\instance_of;

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
        private readonly FiledMerchantTransactionReference $merchantTransactionReference,
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

    public function merchantTransactionReference(): FiledMerchantTransactionReference
    {
        return $this->merchantTransactionReference;
    }

    public function compare($other): int
    {
        instance_of(self::class)->assert($other);

        return Comparison::comparePairs([
            [$this->id, $other->id],
            [$this->status, $other->status],
            [$this->transactionStatus, $other->transactionStatus],
            [$this->merchantTransactionReference, $other->merchantTransactionReference],
        ]);
    }
}
