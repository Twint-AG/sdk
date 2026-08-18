<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use Override;
use Twint\Sdk\Util\Comparison;
use function Psl\Type\instance_of;

/**
 * @template TQrCode of QrCode|null
 * @template TPaymentUrl of PaymentUrl|null
 * @template-implements Value<self<TQrCode, TPaymentUrl>>
 */
final class InteractiveFastCheckoutCheckIn implements Value, FastCheckoutState
{
    /**
     * @use ComparableToEquality<self<TQrCode, TPaymentUrl>>
     */
    use ComparableToEquality;

    /**
     * @param TQrCode $qrCode
     * @param TPaymentUrl $paymentUrl
     */
    public function __construct(
        private readonly PairingUuid $pairingUuid,
        private readonly PairingStatus $pairingStatus,
        private readonly AlphanumericPairingToken $pairingToken,
        private readonly ?QrCode $qrCode,
        private readonly ?PaymentUrl $paymentUrl,
    ) {
    }

    #[Override]
    public function pairingUuid(): PairingUuid
    {
        return $this->pairingUuid;
    }

    #[Override]
    public function pairingStatus(): PairingStatus
    {
        return $this->pairingStatus;
    }

    #[Override]
    public function isPaired(): bool
    {
        return $this->pairingStatus === PairingStatus::PAIRING_ACTIVE;
    }

    /**
     * @return TQrCode
     */
    public function qrCode(): ?QrCode
    {
        return $this->qrCode;
    }

    /**
     * @return TPaymentUrl
     */
    public function paymentUrl(): ?PaymentUrl
    {
        return $this->paymentUrl;
    }

    public function pairingToken(): AlphanumericPairingToken
    {
        return $this->pairingToken;
    }

    #[Override]
    public function compare($other): int
    {
        instance_of(self::class)->assert($other);

        return Comparison::comparePairs([
            [$this->pairingUuid, $other->pairingUuid],
            [$this->pairingToken, $other->pairingToken],
            [$this->pairingStatus, $other->pairingStatus],
            [$this->qrCode, $other->qrCode],
            [$this->paymentUrl, $other->paymentUrl],
        ]);
    }

    /**
     * @return array{
     *     pairingUuid: PairingUuid,
     *     pairingStatus: PairingStatus,
     *     pairingToken: AlphanumericPairingToken,
     *     qrCode: TQrCode,
     *     paymentUrl: TPaymentUrl,
     * }
     */
    #[Override]
    public function jsonSerialize(): array
    {
        return [
            'pairingUuid' => $this->pairingUuid,
            'pairingStatus' => $this->pairingStatus,
            'pairingToken' => $this->pairingToken,
            'qrCode' => $this->qrCode,
            'paymentUrl' => $this->paymentUrl,
        ];
    }
}
