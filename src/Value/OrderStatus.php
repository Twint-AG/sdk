<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use Twint\Sdk\Assertion;
use Twint\Sdk\Exception\AssertionFailed;

/**
 * @template-implements Enum<self::*>
 */
final class OrderStatus implements Enum
{
    public const IN_PROGRESS = 'IN_PROGRESS';

    public const FAILURE = 'FAILURE';

    public const SUCCESS = 'SUCCESS';

    /**
     * @throws AssertionFailed
     */
    public function __construct(
        private readonly string $status
    ) {
        Assertion::choice($status, self::all(), '"%s" is not a valid order status. Supported: %s');
    }

    public function __toString(): string
    {
        return $this->status;
    }

    public function all(): array
    {
        return [self::IN_PROGRESS, self::FAILURE, self::SUCCESS];
    }
}
