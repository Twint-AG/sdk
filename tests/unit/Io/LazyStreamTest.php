<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Io;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Twint\Sdk\Io\LazyStream;
use Twint\Sdk\Io\Stream;

/**
 * @internal
 */
#[CoversClass(LazyStream::class)]
final class LazyStreamTest extends TestCase
{
    public function testLazyStreamIsLazilyInitialized(): void
    {
        $origStream = $this->createMock(Stream::class);
        $origStream
            ->expects(self::never())
            ->method('read');

        new LazyStream($origStream);
    }

    public function testLazyStreamIsInitializedExactlyOnce(): void
    {
        $origStream = $this->createMock(Stream::class);
        $origStream
            ->expects(self::once())
            ->method('read')
            ->willReturn('content');

        $stream = new LazyStream($origStream);

        self::assertSame('content', $stream->read());
        self::assertSame('content', $stream->read());
    }
}
