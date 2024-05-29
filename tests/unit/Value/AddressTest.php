<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Value;

use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use Twint\Sdk\Value\Address;

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
            "John Doe, Rue de l'Ecuyer 5, 8004 Zürich, Switzerland",
            new Address('John', 'Doe', "Rue de l'Ecuyer 5", '8004', 'Zürich', 'Switzerland'),
        ];

        yield [
            "John Doe, Rue de l'Ecuyer 5B, 8004 Zürich, Switzerland",
            new Address('John', 'Doe', "Rue de l'Ecuyer 5B", '8004', 'Zürich', 'Switzerland'),
        ];

        yield [
            'John Frederic Kennedy Chopin, Stauffacher Strasse 41, 8004 Zürich, Switzerland',
            new Address('John Frederic Kennedy', 'Chopin', 'Stauffacher Strasse 41', '8004', 'Zürich', 'Switzerland'),
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
        return new Address('John', 'Doe', 'Main Street 42', '12345', 'Springfield', 'USA');
    }

    #[Override]
    protected static function getValueType(): string
    {
        return Address::class;
    }
}
