<?php

declare(strict_types=1);

namespace Twint\Sdk\Factory;

use Throwable;
use Twint\Sdk\Exception\CryptographyFailure;

final class RandomPassphraseFactory
{
    /**
     * @return non-empty-string
     * @throws CryptographyFailure
     */
    public function __invoke(): string
    {
        try {
            return bin2hex(random_bytes(32));
        } catch (Throwable $e) {
            throw CryptographyFailure::fromThrowable($e);
        }
    }
}
