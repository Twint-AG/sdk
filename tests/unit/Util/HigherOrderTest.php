<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Util;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Twint\Sdk\Util\HigherOrder;

#[CoversClass(HigherOrder::class)]
final class HigherOrderTest extends TestCase
{
    public function testIdentity(): void
    {
        self::assertSame(1, HigherOrder::identity(1));
    }

    public function testDump(): void
    {
        self::expectOutputString('int(1)' . PHP_EOL);

        self::assertSame(1, HigherOrder::dump(1));
    }
}
