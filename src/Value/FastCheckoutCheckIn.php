<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use Override;
use Twint\Sdk\Util\Comparison;
use function Psl\Type\instance_of;

/**
 * @template-implements Value<self>
 */
final class FastCheckoutCheckIn implements Value, FastCheckoutState
{
    /**
     * @use ComparableToEquality<self>
     */
    use ComparableToEquality;

    public function __construct(
        private readonly PairingUuid $pairingUuid,
        private readonly PairingStatus $pairingStatus,
        private readonly ?ShippingMethodId $shippingMethodId,
        private readonly ?CustomerData $customerData
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

    /**
     * @phpstan-assert-if-true !null $this->shippingMethodId()
     */
    public function hasShippingMethodId(): bool
    {
        return $this->shippingMethodId !== null;
    }

    public function shippingMethodId(): ?ShippingMethodId
    {
        return $this->shippingMethodId;
    }

    /**
     * @phpstan-assert-if-true !null $this->customerData()
     */
    public function hasCustomerData(): bool
    {
        return $this->customerData !== null;
    }

    public function customerData(): ?CustomerData
    {
        return $this->customerData;
    }

    #[Override]
    public function compare($other): int
    {
        instance_of(self::class)->assert($other);

        return Comparison::comparePairs([
            [$this->pairingUuid, $other->pairingUuid],
            [$this->pairingStatus, $other->pairingStatus],
            [$this->shippingMethodId, $other->shippingMethodId],
            [$this->customerData, $other->customerData],
        ]);
    }

    /**
     * @return array{
     *     pairingUuid: PairingUuid,
     *     pairingStatus: PairingStatus,
     *     customerData: ?CustomerData,
     *     shippingMethodId: ?ShippingMethodId,
     * }
     */
    #[Override]
    public function jsonSerialize(): array
    {
        return [
            'pairingUuid' => $this->pairingUuid,
            'pairingStatus' => $this->pairingStatus,
            'shippingMethodId' => $this->shippingMethodId,
            'customerData' => $this->customerData,
        ];
    }
}
