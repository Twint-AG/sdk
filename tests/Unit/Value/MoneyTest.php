<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Value;

use PHPUnit\Framework\TestCase;
use Twint\Sdk\Value\Money;

/** @covers \Twint\Sdk\Value\Money */
final class MoneyTest extends TestCase
{
    /**
     * @return iterable<array{Money, Money, int}>
     */
    public static function getComparisons(): iterable
    {
        yield [new Money('EUR', 1000.12), new Money('EUR', 1000.12), 0];
        yield [new Money('EUR', 1000.12), new Money('EUR', 1000.13), -1];
        yield [new Money('EUR', 1000.13), new Money('EUR', 1000.12), 1];
        yield [new Money('EUR', 1000.12), new Money('CHF', 1000.12), 1];
    }

    public function testConvertToString(): void
    {
        self::assertSame('1000.12 EUR', (string) new Money('EUR', 1000.12));
    }

    public function testCommercialRoundingForFormatting(): void
    {
        self::assertSame('1000.13 EUR', (string) new Money('EUR', 1000.125));
        self::assertSame('1000.12 EUR', (string) new Money('EUR', 1000.124));
    }

    public function testCurrencySpecificInstantiation(): void
    {
        self::assertSame('1000.12 EUR', (string) Money::EUR(1000.12));
        self::assertSame('1000.12 CHF', (string) Money::CHF(1000.12));
    }

    public function testAccessors(): void
    {
        $money = new Money('EUR', 1000.12);
        self::assertSame(1000.12, $money->amount());
        self::assertSame('EUR', $money->currency());
    }

    /**
     * @dataProvider getComparisons
     */
    public function testCompare(Money $left, Money $right, int $expected): void
    {
        self::assertSame($expected, $left->compare($right));
    }
}
