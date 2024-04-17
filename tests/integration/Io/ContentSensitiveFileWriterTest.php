<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Integration\Io;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Twint\Sdk\Io\ContentSensitiveFileWriter;
use function Psl\Type\non_empty_string;

#[CoversClass(ContentSensitiveFileWriter::class)]
final class ContentSensitiveFileWriterTest extends TestCase
{
    protected function setUp(): void
    {
        $this->reset();
    }

    protected function tearDown(): void
    {
        $this->reset();
    }

    private function reset(): void
    {
        if (file_exists(sys_get_temp_dir() . '/foo.txt')) {
            unlink(sys_get_temp_dir() . '/foo.txt');
        }

        if (file_exists(sys_get_temp_dir() . '/bar.txt')) {
            unlink(sys_get_temp_dir() . '/bar.txt');
        }
    }

    public function testWritesContentToDynamicallyDeterminedFilename(): void
    {
        $writer = ContentSensitiveFileWriter::fromBaseDirectory(
            non_empty_string()
                ->assert(sys_get_temp_dir()),
            static fn (string $content) => $content . '.txt'
        );

        self::assertFileDoesNotExist(sys_get_temp_dir() . '/foo.txt');
        self::assertFileDoesNotExist(sys_get_temp_dir() . '/bar.txt');

        $writer->write('foo');
        self::assertFileExists(sys_get_temp_dir() . '/foo.txt');

        $writer->write('bar');
        self::assertFileExists(sys_get_temp_dir() . '/bar.txt');
    }

    public function testWritesContentOnce(): void
    {
        file_put_contents('/tmp/foo.txt', 'existing content');
        $writer = ContentSensitiveFileWriter::fromBaseDirectory(
            non_empty_string()
                ->assert(sys_get_temp_dir()),
            static fn (string $content) => $content . '.txt'
        );

        $writer->write('foo');

        self::assertStringEqualsFile('/tmp/foo.txt', 'existing content');
    }
}
