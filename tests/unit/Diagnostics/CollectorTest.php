<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Diagnostics;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Twint\Sdk\Diagnostics\Collector;

/**
 * @internal
 */
#[CoversClass(Collector::class)]
final class CollectorTest extends TestCase
{
    public function testWithDefaultsConstructorReturnsNonEmptyInsights(): void
    {
        $collector = Collector::withDefaults();

        self::assertNotEmpty($collector->insights());
        self::assertEmpty($collector->paths());
    }
}
