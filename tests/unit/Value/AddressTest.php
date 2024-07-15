<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Value;

use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use Twint\Sdk\Value\Address;
use Twint\Sdk\Value\TwoLetterIsoCountryCode;

/**
 * @template-extends ValueTest<Address>
 * @internal
 */
#[CoversClass(Address::class)]
final class AddressTest extends ValueTest
{
    /**
     * @return iterable<array{string, string, string, string, string, string, string}>
     */
    public static function getParseExamples(): iterable
    {
        yield ['Joanna|Doe|Street 123|1234|City|CH', 'Joanna', 'Doe', 'Street 123', '1234', 'City', 'CH'];
    }

    #[DataProvider('getParseExamples')]
    public function testParse(
        string $str,
        string $firstName,
        string $lastName,
        string $street,
        string $zip,
        string $city,
        string $isoCode
    ): void {
        $parsed = Address::parse($str);

        self::assertObjectEquals(
            new Address($firstName, $lastName, $street, $zip, $city, new TwoLetterIsoCountryCode($isoCode)),
            $parsed
        );
        self::assertSame($firstName, $parsed->firstName());
        self::assertSame($lastName, $parsed->lastName());
        self::assertSame($street, $parsed->street());
        self::assertSame($zip, $parsed->zip());
        self::assertSame($city, $parsed->city());
        self::assertObjectEquals(new TwoLetterIsoCountryCode($isoCode), $parsed->country());
    }

    #[Override]
    protected function createValue(): object
    {
        return new Address('John', 'Doe', 'Main Street 42', '12345', 'Springfield', new TwoLetterIsoCountryCode('US'));
    }

    #[Override]
    protected static function getValueType(): string
    {
        return Address::class;
    }
}
