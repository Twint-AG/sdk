<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use Override;
use function Psl\Type\instance_of;

/**
 * @template-implements FixedValues<self::*>
 * @template-implements Value<self>
 */
final class CustomerDataScopes implements Value, FixedValues
{
    /**
     * @use ComparableToEquality<self>
     */
    use ComparableToEquality;

    public const SHIPPING_ADDRESS = 'shipping_address';

    public const DATE_OF_BIRTH = 'date_of_birth';

    public const PHONE_NUMBER = 'phone_number';

    public const EMAIL = 'email';

    /**
     * @var list<self::*>
     */
    private readonly array $scopes;

    /**
     * @param self::* ...$scopes
     */
    public function __construct(string ...$scopes)
    {
        sort($scopes);
        $this->scopes = $scopes;
    }

    /**
     * @return list<self::*>
     */
    #[Override]
    public static function all(): array
    {
        return [self::SHIPPING_ADDRESS, self::DATE_OF_BIRTH, self::PHONE_NUMBER, self::EMAIL];
    }

    /**
     * @return list<self::*>
     */
    public function toList(): array
    {
        return $this->scopes;
    }

    #[Override]
    public function compare($other): int
    {
        instance_of(self::class)->assert($other);

        return $this->scopes <=> $other->scopes;
    }

    /**
     * @return list<self::*>
     */
    #[Override]
    public function jsonSerialize(): mixed
    {
        return $this->scopes;
    }
}
