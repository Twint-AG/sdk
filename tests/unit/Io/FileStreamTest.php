<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Io;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Twint\Sdk\Io\FileStream;
use Twint\Sdk\Value\File;

#[CoversClass(FileStream::class)]
final class FileStreamTest extends TestCase
{
    public function testReadsFileContent(): void
    {
        $stream = new FileStream(new File(__FILE__));

        self::assertStringContainsString(__FUNCTION__, $stream->read());
    }

    public function testProvidesPath(): void
    {
        $file = new File(__FILE__);
        $stream = new FileStream($file);

        self::assertSame($file, $stream->path());
    }
}
