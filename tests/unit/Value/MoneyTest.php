<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Value;

use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use Psl\Exception\InvariantViolationException;
use Twint\Sdk\Value\Money;

/**
 * @template-extends ValueTest<Money>
 * @internal
 */
#[CoversClass(Money::class)]
final class MoneyTest extends ValueTest
{
    /**
     * @return iterable<array{Money, Money, int}>
     */
    public static function getComparisons(): iterable
    {
        yield [new Money(Money::CHF, 1000.12), new Money(Money::CHF, 1000.12), 0];
        yield [new Money(Money::CHF, 1000.12), new Money(Money::CHF, 1000.13), -1];
        yield [new Money(Money::CHF, 1000.13), new Money(Money::CHF, 1000.12), 1];
        yield [new Money(Money::CHF, 1000.12), new Money(Money::XXX, 1000.12), -1];
    }

    public function testConvertToString(): void
    {
        self::assertSame('1000.12 CHF', (string) new Money(Money::CHF, 1000.12));
    }

    public function testCommercialRoundingForFormatting(): void
    {
        self::assertSame('1000.13 CHF', (string) new Money(Money::CHF, 1000.125));
        self::assertSame('1000.12 CHF', (string) new Money(Money::CHF, 1000.124));
    }

    public function testCurrencySpecificInstantiation(): void
    {
        self::assertSame('1000.12 CHF', (string) Money::CHF(1000.12));
    }

    public function testAccessors(): void
    {
        $money = new Money(Money::CHF, 1000.12);
        self::assertSame(1000.12, $money->amount());
        self::assertSame(Money::CHF, $money->currency());
    }

    #[DataProvider('getComparisons')]
    public function testCompare(Money $left, Money $right, int $expected): void
    {
        self::assertSame($expected, $left->compare($right));
    }

    public function testAdd(): void
    {
        self::assertObjectEquals(new Money(Money::CHF, 2000.24), Money::CHF(1000.12)->add(Money::CHF(1000.12)));
    }

    public function testAddThrowsExceptionIfCurrenciesDoNotMatch(): void
    {
        $this->expectException(InvariantViolationException::class);

        Money::CHF(1000.12)->add(Money::XXX(1000.12));
    }

    public function testSubtract(): void
    {
        self::assertObjectEquals(new Money(Money::CHF, 0), Money::CHF(1000.12)->subtract(Money::CHF(1000.12)));
    }

    public function testSubtractThrowsExceptionIfCurrenciesDoNotMatch(): void
    {
        $this->expectException(InvariantViolationException::class);

        Money::CHF(1000.12)->subtract(Money::XXX(1000.12));
    }

    #[Override]
    protected function createValue(): object
    {
        return Money::CHF(1000.12);
    }

    #[Override]
    protected static function getValueType(): string
    {
        return Money::class;
    }
}
