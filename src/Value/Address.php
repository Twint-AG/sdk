<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use Override;
use Stringable;
use Twint\Sdk\Util\Comparison;
use function Psl\invariant;
use function Psl\Type\instance_of;

/**
 * @template-implements Value<Address>
 */
final class Address implements Value, Stringable
{
    /**
     * @use ComparableToEquality<self>
     */
    use ComparableToEquality;

    private const REGEX = '/
        ^
            (?P<firstName>.+?)\|
            (?P<lastName>.+?)\|
            (?P<street>.+?)\|
            (?P<zip>.+?)\|
            (?P<city>.+?)\|
            (?P<country>.+?)
        $
    /xD';

    public function __construct(
        private readonly string $firstName,
        private readonly string $lastName,
        private readonly string $street,
        private readonly string $zip,
        private readonly string $city,
        private readonly TwoLetterIsoCountryCode $country
    ) {
    }

    public static function parse(string $address): self
    {
        invariant(preg_match(self::REGEX, $address, $parts) === 1, 'Cannot parse address "%s"', $address);

        return new self(
            $parts['firstName'],
            $parts['lastName'],
            $parts['street'],
            $parts['zip'],
            $parts['city'],
            new TwoLetterIsoCountryCode($parts['country'])
        );
    }

    #[Override]
    public function __toString(): string
    {
        return sprintf(
            '%s %s, %s, %s %s, %s',
            $this->firstName,
            $this->lastName,
            $this->street,
            $this->zip,
            $this->city,
            $this->country
        );
    }

    #[Override]
    public function compare($other): int
    {
        instance_of(self::class)->assert($other);

        return Comparison::comparePairs(
            [
                [$this->firstName, $other->firstName],
                [$this->lastName, $other->lastName],
                [$this->street, $other->street],
                [$this->zip, $other->zip],
                [$this->city, $other->city],
                [$this->country, $other->country],
            ]
        );
    }

    public function firstName(): string
    {
        return $this->firstName;
    }

    public function lastName(): string
    {
        return $this->lastName;
    }

    public function street(): string
    {
        return $this->street;
    }

    public function zip(): string
    {
        return $this->zip;
    }

    public function city(): string
    {
        return $this->city;
    }

    public function country(): TwoLetterIsoCountryCode
    {
        return $this->country;
    }

    /**
     * @return array{firstName: string, lastName: string, street: string, zip: string, city: string, country: TwoLetterIsoCountryCode}
     */
    #[Override]
    public function jsonSerialize(): array
    {
        return [
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'street' => $this->street,
            'zip' => $this->zip,
            'city' => $this->city,
            'country' => $this->country,
        ];
    }
}
