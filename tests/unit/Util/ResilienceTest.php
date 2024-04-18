<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Util;

use Exception;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Psl\Type\Exception\AssertException;
use Twint\Sdk\Exception\Timeout;
use Twint\Sdk\Util\Resilience;

/**
 * @internal
 */
#[CoversClass(Resilience::class)]
#[CoversClass(Timeout::class)]
final class ResilienceTest extends TestCase
{
    public function testImmediateSuccess(): void
    {
        $result = Resilience::retry(3, static fn () => 1);

        self::assertSame(1, $result);
    }

    public function testSuccessOnSecondAttempt(): void
    {
        $attempts = 0;
        $result = Resilience::retry(3, static function () use (&$attempts) {
            $attempts++;
            if ($attempts === 2) {
                return 1;
            }
            throw new Exception();
        });

        self::assertSame(1, $result);
    }

    public function testExceedsAttempts(): void
    {
        $this->expectException(Timeout::class);

        Resilience::retry(3, static fn () => throw new Exception('Failed'));
    }

    public function testSuccessOnSecondAttemptWithDelay(): void
    {
        $attempts = 0;
        $result = Resilience::retry(3, static function () use (&$attempts) {
            $attempts++;
            if ($attempts === 2) {
                return 1;
            }
            throw new Exception();
        }, 1);

        self::assertSame(1, $result);
    }

    public function testAttemptsMustBePositiveInt(): void
    {
        $this->expectException(AssertException::class);

        // @phpstan-ignore-next-line
        Resilience::retry(0, static fn () => throw new Exception('Failed'));
    }

    public function testAttemptsMustBeUnsignedInt(): void
    {
        $this->expectException(AssertException::class);

        // @phpstan-ignore-next-line
        Resilience::retry(1, static fn () => throw new Exception('Failed'), -1);
    }
}
