<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Value;

use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use Twint\Sdk\Value\SystemStatus;

/**
 * @template-extends ValueTest<SystemStatus>
 * @internal
 */
#[CoversClass(SystemStatus::class)]
final class SystemStatusTest extends ValueTest
{
    #[Override]
    protected function createValue(): object
    {
        return SystemStatus::ERROR();
    }

    #[Override]
    protected static function getValueType(): string
    {
        return SystemStatus::class;
    }

    public function testErrorIsNotOk(): void
    {
        self::assertFalse(SystemStatus::ERROR()->isOk());
    }

    public function testOkIsOk(): void
    {
        self::assertTrue(SystemStatus::OK()->isOk());
    }
}
