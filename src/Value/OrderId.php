<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use Override;
use Stringable;
use function Psl\Type\instance_of;
use function Psl\Type\non_empty_string;

/**
 * @template-implements Value<self>
 */
final class OrderId implements Stringable, Value, OrderReference
{
    /** @use ComparableToEquality<self> */
    use ComparableToEquality;

    public function __construct(
        private readonly Uuid $uuid
    ) {
    }

    public static function fromString(string $uuid): self
    {
        return new self(new Uuid(non_empty_string()->assert($uuid)));
    }

    #[Override]
    public function __toString(): string
    {
        return (string) $this->uuid;
    }

    #[Override]
    public function asOrderUuidString(): string
    {
        return (string) $this;
    }

    #[Override]
    public function asMerchantTransactionReferenceString(): ?string
    {
        return null;
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
}
