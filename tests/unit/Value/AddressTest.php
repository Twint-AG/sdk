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
     * @return iterable<array{string, Address}>
     */
    public static function getParseExamples(): iterable
    {
        yield [
            'Joanna|Doe|Street 123|1234|City|CH',
            new Address('Joanna', 'Doe', 'Street 123', '1234', 'City', new TwoLetterIsoCountryCode('CH')),
        ];
    }

    #[DataProvider('getParseExamples')]
    public function testParse(string $str, Address $address): void
    {
        self::assertObjectEquals($address, Address::parse($str));
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
