<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use Override;
use Twint\Sdk\Util\Comparison;
use function Psl\Type\instance_of;

/**
 * @template-implements Value<self>
 */
final class InteractiveFastCheckoutCheckIn implements Value, FastCheckoutState
{
    /**
     * @use ComparableToEquality<self>
     */
    use ComparableToEquality;

    public function __construct(
        private readonly PairingUuid $pairingUuid,
        private readonly PairingStatus $pairingStatus,
        private readonly AlphanumericPairingToken $pairingToken,
        private readonly QrCode $qrCode
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
        return $this->pairingStatus->equals(PairingStatus::PAIRING_ACTIVE());
    }

    public function qrCode(): QrCode
    {
        return $this->qrCode;
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
            [$this->qrCode, $other->qrCode],
            [$this->pairingToken, $other->pairingToken],
            [$this->pairingStatus, $other->pairingStatus],
        ]);
    }

    /**
     * @return array{
     *     pairingUuid: PairingUuid,
     *     pairingStatus: PairingStatus,
     *     pairingToken: AlphanumericPairingToken,
     *     qrCode: QrCode,
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
        ];
    }
}
