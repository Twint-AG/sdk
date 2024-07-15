<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Value;

use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use Psl\Exception\InvariantViolationException;
use Twint\Sdk\Value\TwoLetterIsoCountryCode;

/**
 * @template-extends ValueTest<TwoLetterIsoCountryCode>
 * @internal
 */
#[CoversClass(TwoLetterIsoCountryCode::class)]
final class TwoLetterIsoCountryCodeTest extends ValueTest
{
    /**
     * @return iterable<array{string}>
     */
    public static function getErrorExamples(): iterable
    {
        yield [''];
        yield ['C'];
        yield ['CHF'];
    }

    #[DataProvider('getErrorExamples')]
    public function testThrowsErrorOnInvalidCode(string $countryCode): void
    {
        $this->expectException(InvariantViolationException::class);

        new TwoLetterIsoCountryCode($countryCode);
    }

    #[Override]
    protected function createValue(): object
    {
        return new TwoLetterIsoCountryCode('CH');
    }

    #[Override]
    protected static function getValueType(): string
    {
        return TwoLetterIsoCountryCode::class;
    }
}
