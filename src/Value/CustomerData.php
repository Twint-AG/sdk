<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use Countable;
use IteratorAggregate;
use Override;
use Traversable;
use Twint\Sdk\Util\Comparison;
use function Psl\Dict\filter_nulls;
use function Psl\Type\instance_of;
use function Psl\Type\optional;
use function Psl\Type\shape;

/**
 * @template-implements IteratorAggregate<string, string>
 * @template-implements Value<self>
 * @phpstan-type CustomerDataDict = array{
 *     shipping_address?: Address,
 *     email?: Email,
 *     phone_number?: PhoneNumber,
 *     date_of_birth?: Date,
 * }
 */
final class CustomerData implements IteratorAggregate, Value, Countable
{
    /**
     * @use ComparableToEquality<CustomerData>
     */
    use ComparableToEquality;

    /**
     * @param CustomerDataDict $data
     */
    public function __construct(
        private readonly array $data
    ) {
    }

    /**
     * @param array<string,mixed> $data
     */
    public static function fromDict(array $data): self
    {
        return new self(
            shape([
                'shipping_address' => optional(instance_of(Address::class)),
                'email' => optional(instance_of(Email::class)),
                'phone_number' => optional(instance_of(PhoneNumber::class)),
                'date_of_birth' => optional(instance_of(Date::class)),
            ])->assert(filter_nulls($data))
        );
    }

    public function email(): ?Email
    {
        return $this->data[CustomerDataScopes::EMAIL] ?? null;
    }

    public function phoneNumber(): ?PhoneNumber
    {
        return $this->data[CustomerDataScopes::PHONE_NUMBER] ?? null;
    }

    public function dateOfBirth(): ?Date
    {
        return $this->data[CustomerDataScopes::DATE_OF_BIRTH] ?? null;
    }

    public function shippingAddress(): ?Address
    {
        return $this->data[CustomerDataScopes::SHIPPING_ADDRESS] ?? null;
    }

    #[Override]
    public function getIterator(): Traversable
    {
        foreach ($this->data as $key => $value) {
            yield $key => (string) $value;
        }
    }

    #[Override]
    public function compare($other): int
    {
        instance_of(self::class)->assert($other);

        return Comparison::comparePairs([
            [
                $this->data[CustomerDataScopes::DATE_OF_BIRTH] ?? null,
                $other->data[CustomerDataScopes::DATE_OF_BIRTH] ?? null,
            ],
            [$this->data[CustomerDataScopes::EMAIL] ?? null, $other->data[CustomerDataScopes::EMAIL] ?? null],
            [
                $this->data[CustomerDataScopes::PHONE_NUMBER] ?? null,
                $other->data[CustomerDataScopes::PHONE_NUMBER] ?? null,
            ],
            [
                $this->data[CustomerDataScopes::SHIPPING_ADDRESS] ?? null,
                $other->data[CustomerDataScopes::SHIPPING_ADDRESS] ?? null,
            ],
        ]);
    }

    #[Override]
    public function count(): int
    {
        return count($this->data);
    }

    /**
     * @return CustomerDataDict
     */
    #[Override]
    public function jsonSerialize(): array
    {
        return $this->data;
    }
}
