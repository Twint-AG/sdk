<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Io;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Twint\Sdk\Io\InMemoryStream;

/**
 * @internal
 */
#[CoversClass(InMemoryStream::class)]
final class InMemoryStreamTest extends TestCase
{
    public function testReadsContent(): void
    {
        $stream = new InMemoryStream('content');

        self::assertSame('content', $stream->read());
    }
}
