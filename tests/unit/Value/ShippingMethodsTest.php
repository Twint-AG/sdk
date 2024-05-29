<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Value;

use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use Psl\Exception\InvariantViolationException;
use Twint\Sdk\Value\Comparable;
use Twint\Sdk\Value\Money;
use Twint\Sdk\Value\ShippingMethod;
use Twint\Sdk\Value\ShippingMethodId;
use Twint\Sdk\Value\ShippingMethods;

/**
 * @template-extends ValueTest<ShippingMethods>
 * @phpstan-import-type ComparisonResult from Comparable
 * @internal
 */
#[CoversClass(ShippingMethods::class)]
final class ShippingMethodsTest extends ValueTest
{
    /**
     * @return iterable<array{list<ShippingMethod>, non-empty-string}>
     */
    public static function getDuplications(): iterable
    {
        yield [
            [
                new ShippingMethod(new ShippingMethodId('1'), 'A', Money::CHF(10)),
                new ShippingMethod(new ShippingMethodId('1'), 'B', Money::CHF(20)),
            ],
            'Duplicate shipping method ID "1" at position 0 and 1',
        ];

        yield [
            [
                new ShippingMethod(new ShippingMethodId('1'), 'A', Money::CHF(10)),
                new ShippingMethod(new ShippingMethodId('2'), 'A', Money::CHF(20)),
            ],
            'Duplicate shipping method label "A" at position 0 and 1',
        ];

        yield [
            [
                new ShippingMethod(new ShippingMethodId('1'), 'A', Money::CHF(10)),
                new ShippingMethod(new ShippingMethodId('2'), 'B', Money::CHF(20)),
                new ShippingMethod(new ShippingMethodId('1'), 'C', Money::CHF(30)),
            ],
            'Duplicate shipping method ID "1" at position 0 and 2',
        ];

        yield [
            [
                new ShippingMethod(new ShippingMethodId('1'), 'A', Money::CHF(10)),
                new ShippingMethod(new ShippingMethodId('2'), 'B', Money::CHF(20)),
                new ShippingMethod(new ShippingMethodId('3'), 'A', Money::CHF(30)),
            ],
            'Duplicate shipping method label "A" at position 0 and 2',
        ];

        $method = new ShippingMethod(new ShippingMethodId('1'), 'A', Money::CHF(10));

        yield [[$method, $method], 'Duplicate shipping method ID "1" at position 0 and 1'];
    }

    /**
     * @return iterable<array{ShippingMethods, ShippingMethods, ComparisonResult}>
     */
    public static function getComparisons(): iterable
    {
        yield [new ShippingMethods(), new ShippingMethods(), 0];

        yield [
            new ShippingMethods(new ShippingMethod(new ShippingMethodId('1'), 'A', Money::CHF(10))),
            new ShippingMethods(new ShippingMethod(new ShippingMethodId('1'), 'A', Money::CHF(10))),
            0,
        ];

        yield [
            new ShippingMethods(new ShippingMethod(new ShippingMethodId('1'), 'A', Money::CHF(10))),
            new ShippingMethods(new ShippingMethod(new ShippingMethodId('2'), 'A', Money::CHF(10))),
            -1,
        ];
        yield [
            new ShippingMethods(new ShippingMethod(new ShippingMethodId('2'), 'A', Money::CHF(10))),
            new ShippingMethods(new ShippingMethod(new ShippingMethodId('1'), 'A', Money::CHF(10))),
            1,
        ];

        yield [
            new ShippingMethods(new ShippingMethod(new ShippingMethodId('1'), 'A', Money::CHF(10))),
            new ShippingMethods(new ShippingMethod(new ShippingMethodId('1'), 'B', Money::CHF(10))),
            -1,
        ];
        yield [
            new ShippingMethods(new ShippingMethod(new ShippingMethodId('1'), 'B', Money::CHF(10))),
            new ShippingMethods(new ShippingMethod(new ShippingMethodId('1'), 'A', Money::CHF(10))),
            1,
        ];

        yield [
            new ShippingMethods(new ShippingMethod(new ShippingMethodId('1'), 'A', Money::CHF(10))),
            new ShippingMethods(new ShippingMethod(new ShippingMethodId('1'), 'A', Money::CHF(20))),
            -1,
        ];
        yield [
            new ShippingMethods(new ShippingMethod(new ShippingMethodId('1'), 'A', Money::CHF(20))),
            new ShippingMethods(new ShippingMethod(new ShippingMethodId('1'), 'A', Money::CHF(10))),
            1,
        ];

        yield [
            new ShippingMethods(new ShippingMethod(new ShippingMethodId('1'), 'A', Money::CHF(10))),
            new ShippingMethods(new ShippingMethod(new ShippingMethodId('2'), 'B', Money::CHF(20))),
            -1,
        ];
        yield [
            new ShippingMethods(new ShippingMethod(new ShippingMethodId('2'), 'B', Money::CHF(20))),
            new ShippingMethods(new ShippingMethod(new ShippingMethodId('1'), 'A', Money::CHF(10))),
            1,
        ];

        yield [
            new ShippingMethods(new ShippingMethod(new ShippingMethodId('1'), 'A', Money::CHF(10))),
            new ShippingMethods(new ShippingMethod(new ShippingMethodId('2'), 'A', Money::CHF(20))),
            -1,
        ];
        yield [
            new ShippingMethods(new ShippingMethod(new ShippingMethodId('2'), 'A', Money::CHF(20))),
            new ShippingMethods(new ShippingMethod(new ShippingMethodId('1'), 'A', Money::CHF(10))),
            1,
        ];

        yield [
            new ShippingMethods(new ShippingMethod(new ShippingMethodId('1'), 'A', Money::CHF(10))),
            new ShippingMethods(new ShippingMethod(new ShippingMethodId('1'), 'B', Money::CHF(20))),
            -1,
        ];
        yield [
            new ShippingMethods(new ShippingMethod(new ShippingMethodId('1'), 'B', Money::CHF(20))),
            new ShippingMethods(new ShippingMethod(new ShippingMethodId('1'), 'A', Money::CHF(10))),
            1,
        ];

        yield [
            new ShippingMethods(new ShippingMethod(new ShippingMethodId('1'), 'A', Money::CHF(10))),
            new ShippingMethods(new ShippingMethod(new ShippingMethodId('1'), 'A', Money::CHF(20))),
            -1,
        ];
        yield [
            new ShippingMethods(new ShippingMethod(new ShippingMethodId('1'), 'A', Money::CHF(20))),
            new ShippingMethods(new ShippingMethod(new ShippingMethodId('1'), 'A', Money::CHF(10))),
            1,
        ];

        yield [
            new ShippingMethods(new ShippingMethod(new ShippingMethodId('1'), 'A', Money::CHF(20))),
            new ShippingMethods(
                new ShippingMethod(new ShippingMethodId('1'), 'A', Money::CHF(20)),
                new ShippingMethod(new ShippingMethodId('2'), 'B', Money::CHF(30)),
            ),
            -1,
        ];
        yield [
            new ShippingMethods(
                new ShippingMethod(new ShippingMethodId('1'), 'A', Money::CHF(20)),
                new ShippingMethod(new ShippingMethodId('2'), 'B', Money::CHF(30)),
            ),
            new ShippingMethods(new ShippingMethod(new ShippingMethodId('1'), 'A', Money::CHF(20))),
            1,
        ];

        yield [
            new ShippingMethods(
                new ShippingMethod(new ShippingMethodId('1'), 'A', Money::CHF(20)),
                new ShippingMethod(new ShippingMethodId('2'), 'B', Money::CHF(30)),
            ),
            new ShippingMethods(
                new ShippingMethod(new ShippingMethodId('1'), 'A', Money::CHF(20)),
                new ShippingMethod(new ShippingMethodId('2'), 'B', Money::CHF(30)),
            ),
            0,
        ];
        yield [
            new ShippingMethods(
                new ShippingMethod(new ShippingMethodId('1'), 'A', Money::CHF(20)),
                new ShippingMethod(new ShippingMethodId('2'), 'B', Money::CHF(30)),
            ),
            new ShippingMethods(
                new ShippingMethod(new ShippingMethodId('2'), 'B', Money::CHF(30)),
                new ShippingMethod(new ShippingMethodId('1'), 'A', Money::CHF(20)),
            ),
            0,
        ];
    }

    #[Override]
    protected function createValue(): object
    {
        return new ShippingMethods();
    }

    #[Override]
    protected static function getValueType(): string
    {
        return ShippingMethods::class;
    }

    /**
     * @param list<ShippingMethod> $methods
     */
    #[DataProvider('getDuplications')]
    public function testDuplicateShippingIdDetected(array $methods, string $exceptionMessage): void
    {
        $this->expectException(InvariantViolationException::class);
        $this->expectExceptionMessage($exceptionMessage);

        new ShippingMethods(...$methods);
    }

    public function testImmutableAdd(): void
    {
        $prevMethods = new ShippingMethods();
        $method = new ShippingMethod(new ShippingMethodId('1'), 'A', Money::CHF(10));

        $nextMethods = $prevMethods->add($method);

        self::assertNotSame($prevMethods, $nextMethods);
        self::assertCount(0, $prevMethods);
        self::assertCount(1, $nextMethods);
        self::assertSame($method, iterator_to_array($nextMethods)[0]);
    }

    #[DataProvider('getComparisons')]
    public function testCompare(ShippingMethods $a, ShippingMethods $b, int $expected): void
    {
        self::assertSame($expected, $a->compare($b));
    }
}
