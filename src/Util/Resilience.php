<?php

declare(strict_types=1);

namespace Twint\Sdk\Util;

use Throwable;
use Twint\Sdk\Exception\Timeout;

final class Resilience
{
    /**
     * @template T
     * @param callable(): T $operation
     * @throws Timeout
     * @return T
     */
    public static function retry(int $times, callable $operation, int $delayMs = 0): mixed
    {
        $attempts = 0;

        do {
            try {
                return $operation();
            } catch (Throwable $e) {
                if (++$attempts === $times) {
                    throw Timeout::fromThrowable($e);
                }

                if ($delayMs > 0) {
                    usleep($delayMs * 1000);
                }
            }
        } while ($attempts < $times);

        throw new Timeout('Unreachable');
    }
}
