<?php

declare(strict_types=1);

namespace Twint\Sdk\Exception;

use Deprecated;
use RuntimeException;
use Throwable;

final class Timeout extends RuntimeException implements SdkError
{
    // @codeCoverageIgnoreStart
    #[Deprecated]
    public static function fromThrowable(Throwable $throwable): self
    {
        return new self($throwable->getMessage(), (int) $throwable->getCode(), $throwable);
    }
    // @codeCoverageIgnoreEnd

    public static function fromRetries(int $retries, int $delayMs, Throwable $throwable): self
    {
        return new self(
            sprintf('Operation timed out after %d retries with %dms delay', $retries, $delayMs),
            0,
            $throwable
        );
    }
}
