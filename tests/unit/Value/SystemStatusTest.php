<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Value;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Twint\Sdk\Value\SystemStatus;

/**
 * @internal
 */
#[CoversClass(SystemStatus::class)]
final class SystemStatusTest extends TestCase
{
    public function testErrorIsNotOk(): void
    {
        self::assertFalse(SystemStatus::ERROR->isOk());
    }

    public function testOkIsOk(): void
    {
        self::assertTrue(SystemStatus::OK->isOk());
    }
}
