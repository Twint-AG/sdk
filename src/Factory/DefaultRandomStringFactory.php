<?php

declare(strict_types=1);

namespace Twint\Sdk\Factory;

use Throwable;
use Twint\Sdk\Exception\CryptographyFailure;

/**
 * @phpstan-type Length 16|32|64|128|256
 */
final class DefaultRandomStringFactory
{
    /**
     * @param Length $length
     * @throws CryptographyFailure
     */
    public function __invoke(int $length): string
    {
        try {
            return bin2hex(random_bytes($length / 2));
        } catch (Throwable $e) {
            throw CryptographyFailure::fromThrowable($e);
        }
    }
}
