<?php

declare(strict_types=1);

namespace Twint\Sdk\Util;

use Throwable;
use Twint\Sdk\Exception\Timeout;
use function Psl\Type\positive_int;
use function Psl\Type\uint;

/**
 * @phpstan-type DelayMs = int<0, max>
 * @phpstan-type Attempts = int<1, max>
 */
final class Resilience
{
    /**
     * @template T
     * @param Attempts $times
     * @param callable(): T $operation
     * @param DelayMs $delayMs
     * @throws Timeout
     * @return T
     */
    public static function retry(int $times, callable $operation, int $delayMs = 0): mixed
    {
        positive_int()
            ->assert($times);
        uint()
            ->assert($delayMs);

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

        // @codeCoverageIgnoreStart
        throw new Timeout('Unreachable code reached');
        // @codeCoverageIgnoreEnd
    }
}
