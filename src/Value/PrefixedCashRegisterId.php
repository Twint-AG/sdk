<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use Override;
use Twint\Sdk\Util\Comparison;
use function Psl\invariant;
use function Psl\Type\instance_of;

/**
 * @template-implements Value<self>
 */
final class PrefixedCashRegisterId implements Value, CashRegisterId
{
    /**
     * @use ComparableToEquality<self>
     */
    use ComparableToEquality;

    public const UNKNOWN = 'Unknown';

    private const MAX_CASH_REGISTER_ID_LENGTH = 50;

    private const SEPARATOR_LENGTH = 1;

    private const MAX_LENGTH = self::MAX_CASH_REGISTER_ID_LENGTH - StoreUuid::LENGTH - self::SEPARATOR_LENGTH;

    /**
     * @param non-empty-string $prefix
     */
    public function __construct(
        private readonly StoreUuid $storeUuid,
        private readonly string $prefix
    ) {
        invariant($prefix !== '', 'Prefix must not be empty');
        invariant(
            strlen($prefix) <= self::MAX_LENGTH,
            'Prefix must be at most %d characters long',
            self::MAX_LENGTH
        );
        invariant(
            preg_match('/^[a-zA-Z0-9_-]+$/', $prefix) === 1,
            'Prefix must contain only letters, digits, dashes, and underscores'
        );
    }

    public static function unknown(StoreUuid $storeUuid): self
    {
        return new self($storeUuid, self::UNKNOWN);
    }

    #[Override]
    public function __toString(): string
    {
        return $this->prefix . '-' . $this->storeUuid;
    }

    #[Override]
    public function storeUuid(): StoreUuid
    {
        return $this->storeUuid;
    }

    #[Override]
    public function cashRegisterId(): self
    {
        return $this;
    }

    #[Override]
    public function compare($other): int
    {
        instance_of(self::class)->assert($other);

        return Comparison::comparePairs([[$this->prefix, $other->prefix], [$this->storeUuid, $other->storeUuid]]);
    }

    /**
     * @return array{prefix: string, storeUuid: StoreUuid}
     */
    #[Override]
    public function jsonSerialize(): array
    {
        return [
            'prefix' => $this->prefix,
            'storeUuid' => $this->storeUuid,
        ];
    }
}
