<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Io;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Twint\Sdk\Io\InMemoryStream;
use Twint\Sdk\Io\ProcessingStream;

#[CoversClass(ProcessingStream::class)]
final class ProcessingStreamTest extends TestCase
{
    public function testReadsContent(): void
    {
        $stream = new ProcessingStream(
            new InMemoryStream('content'),
            static fn (string $v) => $v . '_processed',
        );

        self::assertSame('content_processed', $stream->read());
    }
}
