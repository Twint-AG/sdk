<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use Override;
use function Psl\Type\instance_of;

/**
 * @template-implements Value<self>
 */
final class MerchantId implements Value, CashRegisterId
{
    /** @use ComparableToEquality<self> */
    use ComparableToEquality;

    public const LENGTH = Uuid::LENGTH;

    public function __construct(
        private readonly Uuid $uuid
    ) {
    }

    public static function fromString(string $uuid): self
    {
        return new self(new Uuid($uuid));
    }

    #[Override]
    public function __toString(): string
    {
        return (string) $this->uuid;
    }

    #[Override]
    public function compare($other): int
    {
        instance_of(self::class)->assert($other);

        return $this->uuid->compare($other->uuid);
    }

    #[Override]
    public function jsonSerialize(): Uuid
    {
        return $this->uuid;
    }

    #[Override]
    public function merchantId(): self
    {
        return $this;
    }

    #[Override]
    public function cashRegisterId(): ?CashRegisterId
    {
        return null;
    }
}
