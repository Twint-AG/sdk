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
     * @param callable(int<1,max>): string $randomBytes
     */
    public function __construct(
        private readonly mixed $randomBytes = 'random_bytes'
    ) {
    }

    /**
     * @param Length $length
     * @throws CryptographyFailure
     */
    public function __invoke(int $length): string
    {
        try {
            return bin2hex(($this->randomBytes)($length / 2));
        } catch (Throwable $e) {
            throw CryptographyFailure::fromThrowable($e);
        }
    }
}
