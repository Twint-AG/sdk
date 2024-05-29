<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Value;

use DateTimeImmutable;
use DateTimeZone;
use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use Twint\Sdk\Value\Date;

/**
 * @template-extends ValueTest<Date>
 * @internal
 */
#[CoversClass(Date::class)]
final class DateTest extends ValueTest
{
    #[Override]
    protected function createValue(): object
    {
        return new Date(2021, 10, 31);
    }

    #[Override]
    protected static function getValueType(): string
    {
        return Date::class;
    }

    public function testParseSlashSeparated(): void
    {
        $date = Date::parse('31/10/2021');

        self::assertObjectEquals(new Date(2021, 10, 31), $date);
    }

    public function testAccessors(): void
    {
        $date = new Date(2021, 10, 31);

        self::assertSame(2021, $date->year());
        self::assertSame(10, $date->month());
        self::assertSame(31, $date->day());
    }

    public function testToDateTime(): void
    {
        $date = new Date(2021, 10, 31);

        self::assertThat(
            $date->toDateTime(new DateTimeZone('America/Chicago')),
            self::equalTo(new DateTimeImmutable('2021-10-31 00:00:00.0-0500'))
        );
    }
}
