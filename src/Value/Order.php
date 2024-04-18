<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use Override;
use Twint\Sdk\Util\Comparison;
use function Psl\Type\instance_of;

/**
 * @template TPairingStatus of PairingStatus|null
 * @template TPairingToken of PairingToken|null
 * @template TQrCode of QrCode|null
 * @template-implements Comparable<self<PairingStatus, TPairingToken, TQrCode>>
 * @template-implements Equality<self<PairingStatus, TPairingToken, TQrCode>>
 */
final class Order implements Comparable, Equality
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
        private readonly ?PairingStatus $pairingStatus = null,
        private readonly ?PairingToken $pairingToken = null,
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
    public function pairingToken(): ?PairingToken
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

    #[Override]
    public function compare($other): int
    {
        instance_of(self::class)->assert($other);

        return Comparison::comparePairs([
            [$this->id, $other->id],
            [$this->merchantTransactionReference, $other->merchantTransactionReference],
            [$this->status, $other->status],
            [$this->transactionStatus, $other->transactionStatus],
            [$this->pairingStatus, $other->pairingStatus],
            [$this->pairingToken, $other->pairingToken],
        ]);
    }
}
