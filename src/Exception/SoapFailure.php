<?php

declare(strict_types=1);

namespace Twint\Sdk\Exception;

use RuntimeException;
use Throwable;

final class SoapFailure extends RuntimeException implements SdkError
{
    public static function fromThrowable(Throwable $throwable): self
    {
        return new self($throwable->getMessage(), $throwable->getCode(), $throwable);
    }
}
