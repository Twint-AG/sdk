<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

final class Order
{
    public function __construct(
        private readonly OrderId $id,
        private readonly OrderStatus $status,
        private readonly TransactionStatus $transactionStatus
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
}
