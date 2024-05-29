<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use DateTimeImmutable;
use DateTimeZone;
use Override;
use Stringable;
use Twint\Sdk\Util\Comparison;
use function Psl\invariant;
use function Psl\Type\instance_of;
use function Psl\Type\uint;
use function Psl\Type\vec;

/**
 * @template-implements Value<self>
 * @phpstan-type Year = int<self::YEAR_MIN, self::YEAR_MAX>
 * @phpstan-type Month = int<self::MONTH_MIN, self::MONTH_MAX>
 * @phpstan-type Day = int<self::DAY_MIN, self::DAY_MAX>
 */
final class Date implements Value, Stringable
{
    /**
     * @use ComparableToEquality<self>
     */
    use ComparableToEquality;

    private const YEAR_MIN = 1900;

    private const YEAR_MAX = 2100;

    private const MONTH_MIN = 1;

    private const MONTH_MAX = 12;

    private const DAY_MIN = 1;

    private const DAY_MAX = 31;

    /**
     * @param Year $year
     * @param Month $month
     * @param Day $day
     */
    public function __construct(
        private readonly int $year,
        private readonly int $month,
        private readonly int $day
    ) {
        invariant(checkdate($month, $day, $year), 'Invalid date: %d-%d-%d', $year, $month, $day);
    }

    public static function parse(string $date): self
    {
        [$day, $month, $year] = vec(uint())->assert(array_map('intval', explode('/', $date)));

        invariant($year >= self::YEAR_MIN && $year <= self::YEAR_MAX, 'Invalid year: %d', $year);
        invariant($month >= self::MONTH_MIN && $month <= self::MONTH_MAX, 'Invalid month: %d', $month);
        invariant($day >= self::DAY_MIN && $day <= self::DAY_MAX, 'Invalid day: %d', $day);

        return new self($year, $month, $day);
    }

    #[Override]
    public function __toString(): string
    {
        return sprintf('%0004d-%02d-%02d', $this->year, $this->month, $this->day);
    }

    public function year(): int
    {
        return $this->year;
    }

    public function month(): int
    {
        return $this->month;
    }

    public function day(): int
    {
        return $this->day;
    }

    public function toDateTime(DateTimeZone $timeZone): DateTimeImmutable
    {
        // @phpstan-ignore-next-line
        return new DateTimeImmutable(sprintf('%d-%d-%d', $this->year, $this->month, $this->day), $timeZone);
    }

    #[Override]
    public function compare($other): int
    {
        instance_of(self::class)->assert($other);

        return Comparison::comparePairs([
            [$this->year, $other->year],
            [$this->month, $other->month],
            [$this->day, $other->day],
        ]);
    }

    /**
     * @return array{year: Year, month: Month, day: Day}
     */
    #[Override]
    public function jsonSerialize(): array
    {
        return [
            'year' => $this->year,
            'month' => $this->month,
            'day' => $this->day,
        ];
    }
}
