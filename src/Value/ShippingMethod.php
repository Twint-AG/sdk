<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use Override;
use Twint\Sdk\Util\Comparison;
use function Psl\Type\instance_of;

/**
 * @template-implements Value<self>
 */
final class ShippingMethod implements Value
{
    /**
     * @use ComparableToEquality<self>
     */
    use ComparableToEquality;

    public function __construct(
        private readonly ShippingMethodId $id,
        private readonly string $label,
        private readonly Money $price
    ) {
    }

    public function id(): ShippingMethodId
    {
        return $this->id;
    }

    public function label(): string
    {
        return $this->label;
    }

    public function price(): Money
    {
        return $this->price;
    }

    #[Override]
    public function compare($other): int
    {
        instance_of(self::class)->assert($other);

        return Comparison::comparePairs([
            [$this->id, $other->id()],
            [$this->label, $other->label()],
            [$this->price, $other->price()],
        ]);
    }

    /**
     * @return array{id: ShippingMethodId, label: string, price: Money}
     */
    #[Override]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'label' => $this->label,
            'price' => $this->price,
        ];
    }
}
