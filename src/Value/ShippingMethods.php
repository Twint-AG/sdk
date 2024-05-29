<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use Countable;
use IteratorAggregate;
use Override;
use Traversable;
use Twint\Sdk\Util\Comparison;
use function Psl\invariant;
use function Psl\Type\instance_of;

/**
 * @template-implements IteratorAggregate<ShippingMethod>
 * @template-implements Value<self>
 */
final class ShippingMethods implements IteratorAggregate, Value, Countable
{
    /**
     * @use ComparableToEquality<self>
     */
    use ComparableToEquality;

    /**
     * @readonly
     * @var list<ShippingMethod>
     */
    private array $methods;

    public function __construct(ShippingMethod ...$methods)
    {
        foreach ($methods as $methodIdx => $method) {
            foreach ($methods as $otherIdx => $other) {
                if ($methodIdx === $otherIdx) {
                    continue;
                }

                invariant(
                    !$method->id()
                        ->equals($other->id()),
                    'Duplicate shipping method ID "%s" at position %d and %d',
                    (string) $method->id(),
                    $methodIdx,
                    $otherIdx
                );

                invariant(
                    $method->label() !== $other->label(),
                    'Duplicate shipping method label "%s" at position %d and %d',
                    $method->label(),
                    $methodIdx,
                    $otherIdx
                );
            }
        }

        $this->methods = array_values($methods);
    }

    public function __clone(): void
    {
        // @phpstan-ignore-next-line
        $this->methods = array_map(static fn (ShippingMethod $method): ShippingMethod => clone $method, $this->methods);
    }

    public function add(ShippingMethod $method): self
    {
        return new self(...[...$this->methods, $method]);
    }

    /**
     * @return Traversable<int, ShippingMethod>
     */
    #[Override]
    public function getIterator(): Traversable
    {
        yield from $this->methods;
    }

    #[Override]
    public function compare($other): int
    {
        instance_of(self::class)->assert($other);

        $compare = static fn (ShippingMethod $left, ShippingMethod $right): int => $left->compare($right);

        $leftDiff = array_udiff($this->methods, $other->methods, $compare);
        $rightDiff = array_udiff($other->methods, $this->methods, $compare);

        if (count($leftDiff) === 0 && count($rightDiff) === 0) {
            return 0;
        }

        return Comparison::comparePairs(array_values(array_map(static fn ($a, $b) => [$a, $b], $leftDiff, $rightDiff)));
    }

    #[Override]
    public function count(): int
    {
        return count($this->methods);
    }

    /**
     * @return list<ShippingMethod>
     */
    #[Override]
    public function jsonSerialize(): array
    {
        return $this->methods;
    }
}
