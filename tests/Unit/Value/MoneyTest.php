<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Value;

use PHPUnit\Framework\TestCase;
use Twint\Sdk\Value\Money;

/** @covers \Twint\Sdk\Value\Money */
final class MoneyTest extends TestCase
{
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
}
