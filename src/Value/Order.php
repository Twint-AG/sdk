<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use Override;
use Twint\Sdk\Util\Comparison;
use function Psl\Type\instance_of;

/**
 * @template TPairingStatus of PairingStatus|null
 * @template TPairingToken of NumericPairingToken|null
 * @template TQrCode of QrCode|null
 * @template-implements Value<self<PairingStatus, TPairingToken, TQrCode>>
 */
final class Order implements Value
{
    /** @use ComparableToEquality<self<PairingStatus, TPairingToken, TQrCode>> */
    use ComparableToEquality;

    /**
     * @param TPairingStatus $pairingStatus
     * @param TPairingToken $pairingToken
     * @param TQrCode $qrCode
     */
    public function __construct(
        private readonly OrderId $id,
        private readonly FiledMerchantTransactionReference $merchantTransactionReference,
        private readonly OrderStatus $status,
        private readonly TransactionStatus $transactionStatus,
        private readonly Money $amount,
        private readonly ?PairingStatus $pairingStatus = null,
        private readonly ?NumericPairingToken $pairingToken = null,
        private readonly ?QrCode $qrCode = null,
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

    /**
     * @return TPairingStatus
     */
    public function pairingStatus(): ?PairingStatus
    {
        return $this->pairingStatus;
    }

    public function requiresPairing(): bool
    {
        return $this->pairingStatus !== null && $this->pairingStatus->equals(PairingStatus::PAIRING_IN_PROGRESS());
    }

    /**
     * @return TPairingToken
     */
    public function pairingToken(): ?NumericPairingToken
    {
        return $this->pairingToken;
    }

    public function merchantTransactionReference(): FiledMerchantTransactionReference
    {
        return $this->merchantTransactionReference;
    }

    public function qrCode(): ?QrCode
    {
        return $this->qrCode;
    }

    public function isSuccessful(): bool
    {
        return $this->status->equals(OrderStatus::SUCCESS());
    }

    public function isFailure(): bool
    {
        return $this->status->equals(OrderStatus::FAILURE());
    }

    public function isPending(): bool
    {
        return $this->status->equals(OrderStatus::IN_PROGRESS());
    }

    public function userInteractionRequired(): bool
    {
        return $this->status->equals(OrderStatus::IN_PROGRESS())
            && (
                $this->transactionStatus->equals(TransactionStatus::ORDER_PENDING())
                || $this->transactionStatus->equals(TransactionStatus::ORDER_RECEIVED())
            );
    }

    public function isConfirmationPending(): bool
    {
        return $this->status->equals(OrderStatus::IN_PROGRESS())
            && $this->transactionStatus->equals(TransactionStatus::ORDER_CONFIRMATION_PENDING());
    }

    public function amount(): Money
    {
        return $this->amount;
    }

    #[Override]
    public function compare($other): int
    {
        instance_of(self::class)->assert($other);

        return Comparison::comparePairs([
            [$this->id, $other->id],
            [$this->merchantTransactionReference, $other->merchantTransactionReference],
            [$this->status, $other->status],
            [$this->transactionStatus, $other->transactionStatus],
            [$this->amount, $other->amount],
            [$this->pairingStatus, $other->pairingStatus],
            [$this->pairingToken, $other->pairingToken],
            [$this->qrCode, $other->qrCode],
        ]);
    }

    /**
     * @return array{
     *     id: OrderId,
     *     merchantTransactionReference: FiledMerchantTransactionReference,
     *     status: OrderStatus,
     *     transactionStatus: TransactionStatus,
     *     amount: Money,
     *     pairingStatus: PairingStatus|null,
     *     pairingToken: NumericPairingToken|null,
     *     qrCode: QrCode|null
     * }
     */
    #[Override]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'merchantTransactionReference' => $this->merchantTransactionReference,
            'status' => $this->status,
            'transactionStatus' => $this->transactionStatus,
            'amount' => $this->amount,
            'pairingStatus' => $this->pairingStatus,
            'pairingToken' => $this->pairingToken,
            'qrCode' => $this->qrCode,
        ];
    }
}
