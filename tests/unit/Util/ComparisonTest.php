<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Util;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Twint\Sdk\Util\Comparison;
use Twint\Sdk\Value\Comparable;

/**
 * @internal
 */
#[CoversClass(Comparison::class)]
final class ComparisonTest extends TestCase
{
    /**
     * @return iterable<array{list<array{Comparable<covariant object>|scalar|null, Comparable<covariant object>|scalar|null}>, int}>
     */
    public static function getComparisons(): iterable
    {
        yield [[], 0];
        yield [[[null, null]], 0];
        yield [[[new ComparableImpl(1), new ComparableImpl(1)]], 0];
        yield [
            [[new ComparableImpl(1), new ComparableImpl(1)], [new ComparableImpl(1), new ComparableImpl(0)]],
            1,
        ];
        yield [
            [[new ComparableImpl(1), new ComparableImpl(1)], [new ComparableImpl(0), new ComparableImpl(1)]],
            -1,
        ];
        yield [[[new ComparableImpl(1), null]], 1];
        yield [[[null, new ComparableImpl(1)]], -1];
        yield [[[null, null], [new ComparableImpl(1), new ComparableImpl(1)], [null, new ComparableImpl(1)]], -1];
        yield [[[1, 1]], 0];
        yield [[[0, 1]], -1];
        yield [[[0, 0], [new ComparableImpl(10), new ComparableImpl(10)], [null, null], [0, 1]], -1];
    }

    /**
     * @template ComparableObject of object
     * @template ComparableValue of Comparable<ComparableObject>|null|scalar
     * @param list<array{ComparableValue, ComparableValue}> $pairs
     */
    #[DataProvider('getComparisons')]
    public function testComparePairs(array $pairs, int $result): void
    {
        self::assertSame($result, Comparison::comparePairs($pairs));
    }
}
