<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use Override;
use Twint\Sdk\Util\Type;
use function Psl\Type\instance_of;

/**
 * @template-implements Enum<self::*>
 * @template-implements Value<self>
 */
final class TransactionStatus implements Value, Enum
{
    /** @use ComparableToEquality<self> */
    use ComparableToEquality;

    public const ORDER_OK = 'ORDER_OK';

    public const ORDER_PARTIAL_OK = 'ORDER_PARTIAL_OK';

    public const ORDER_RECEIVED = 'ORDER_RECEIVED';

    public const ORDER_PENDING = 'ORDER_PENDING';

    public const ORDER_CONFIRMATION_PENDING = 'ORDER_CONFIRMATION_PENDING';

    public const GENERAL_ERROR = 'GENERAL_ERROR';

    public const CLIENT_TIMEOUT = 'CLIENT_TIMEOUT';

    public const MERCHANT_ABORT = 'MERCHANT_ABORT';

    public const CLIENT_ABORT = 'CLIENT_ABORT';

    /**
     * @param self::* $status
     */
    public function __construct(
        private readonly string $status
    ) {
        Type::maybeUnionOfLiterals(...self::all())->assert($status);
    }

    public static function fromString(string $status): self
    {
        /** @var self::* $status */
        $status = Type::maybeUnionOfLiterals(...self::all())->assert($status);

        return new self($status);
    }

    public static function ORDER_OK(): self
    {
        return new self(self::ORDER_OK);
    }

    public static function ORDER_PARTIAL_OK(): self
    {
        return new self(self::ORDER_PARTIAL_OK);
    }

    public static function ORDER_RECEIVED(): self
    {
        return new self(self::ORDER_RECEIVED);
    }

    public static function ORDER_PENDING(): self
    {
        return new self(self::ORDER_PENDING);
    }

    public static function ORDER_CONFIRMATION_PENDING(): self
    {
        return new self(self::ORDER_CONFIRMATION_PENDING);
    }

    public static function GENERAL_ERROR(): self
    {
        return new self(self::GENERAL_ERROR);
    }

    public static function CLIENT_TIMEOUT(): self
    {
        return new self(self::CLIENT_TIMEOUT);
    }

    public static function MERCHANT_ABORT(): self
    {
        return new self(self::MERCHANT_ABORT);
    }

    public static function CLIENT_ABORT(): self
    {
        return new self(self::CLIENT_ABORT);
    }

    /**
     * @return list<self::*>
     */
    #[Override]
    public static function all(): array
    {
        return [
            self::ORDER_OK,
            self::ORDER_PARTIAL_OK,
            self::ORDER_RECEIVED,
            self::ORDER_PENDING,
            self::ORDER_CONFIRMATION_PENDING,
            self::GENERAL_ERROR,
            self::CLIENT_TIMEOUT,
            self::MERCHANT_ABORT,
            self::CLIENT_ABORT,
        ];
    }

    #[Override]
    public function __toString(): string
    {
        return $this->status;
    }

    #[Override]
    public function compare($other): int
    {
        instance_of(self::class)->assert($other);

        return $this->status <=> $other->status;
    }

    #[Override]
    public function jsonSerialize(): string
    {
        return $this->status;
    }
}
