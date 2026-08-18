<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use Override;
use Twint\Sdk\Util\Comparison;
use Twint\Sdk\Util\ShippingLabelTransliterator;
use function Psl\invariant;
use function Psl\Str\length;
use function Psl\Type\instance_of;
use function Psl\Type\non_empty_string;

/**
 * @template-implements Value<self>
 */
final class ShippingMethod implements Value
{
    /**
     * @use ComparableToEquality<self>
     */
    use ComparableToEquality;

    private const MAX_LABEL_LENGTH = 255;

    /**
     * @var non-empty-string
     */
    private readonly string $label;

    /**
     * @param non-empty-string $label
     * @param callable(string): string $transliterator
     */
    public function __construct(
        private readonly ShippingMethodId $id,
        string $label,
        private readonly Money $price,
        callable $transliterator = new ShippingLabelTransliterator()
    ) {
        non_empty_string()->assert($label);
        invariant(
            length($label) <= self::MAX_LABEL_LENGTH,
            'Shipping method label cannot exceed %d characters',
            self::MAX_LABEL_LENGTH
        );
        $this->label = non_empty_string()
            ->assert($transliterator($label));
    }

    public function id(): ShippingMethodId
    {
        return $this->id;
    }

    /**
     * @return non-empty-string
     */
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
     * @return array{id: ShippingMethodId, label: non-empty-string, price: Money}
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
