<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Value;

use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use Stringable;
use Twint\Sdk\Value\Address;
use Twint\Sdk\Value\CustomerData;
use Twint\Sdk\Value\Date;
use Twint\Sdk\Value\Email;
use Twint\Sdk\Value\PhoneNumber;
use Twint\Sdk\Value\TwoLetterIsoCountryCode;
use function Psl\Dict\filter_nulls;

/**
 * @template-extends ValueTest<CustomerData>
 * @internal
 * @phpstan-import-type CustomerDataDict from CustomerData
 */
#[CoversClass(CustomerData::class)]
final class CustomerDataTest extends ValueTest
{
    /**
     * @return iterable<array{array<string,null|Stringable>, int}>
     */
    public static function getDictionaries(): iterable
    {
        yield [[
            'shipping_address' => new Address(
                'John',
                'Doe',
                'Street 1',
                '12343',
                'City',
                new TwoLetterIsoCountryCode('CH')
            ),
        ], 1];
        yield [[
            'email' => new Email('foo@host.com'),
        ], 1];
        yield [[
            'phone_number' => new PhoneNumber('1234567890'),
        ], 1];
        yield [[
            'date_of_birth' => new Date(1990, 1, 1),
        ], 1];
        yield [[
            'date_of_birth' => null,
            'phone_number' => null,
            'email' => null,
            'shipping_address' => null,
        ], 0];
    }

    /**
     * @param array<string, null|Stringable> $dict
     */
    #[DataProvider('getDictionaries')]
    public static function testCreateFromDict(array $dict, int $count): void
    {
        $customerData = CustomerData::fromDict($dict);

        self::assertSame(array_map('strval', filter_nulls($dict)), iterator_to_array($customerData));

        foreach ($dict as $field => $value) {
            self::assertThat(
                match ($field) {
                    'shipping_address' => $customerData->shippingAddress(),
                    'email' => $customerData->email(),
                    'phone_number' => $customerData->phoneNumber(),
                    'date_of_birth' => $customerData->dateOfBirth(),
                    default => self::fail(sprintf('Unexpected field: "%s"', $field)),
                },
                $value === null ? self::isNull() : self::objectEquals($value)
            );
        }

        self::assertCount($count, $customerData);
    }

    #[Override]
    protected function createValue(): object
    {
        return new CustomerData([]);
    }

    #[Override]
    protected static function getValueType(): string
    {
        return CustomerData::class;
    }
}
