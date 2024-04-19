<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Integration\Io;

use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Twint\Sdk\Io\StaticFileWriter;

/**
 * @internal
 */
#[CoversClass(StaticFileWriter::class)]
final class StaticFileWriterTest extends TestCase
{
    private readonly StaticFileWriter $writer;

    private string $file;

    #[Override]
    protected function setUp(): void
    {
        $this->file = sys_get_temp_dir() . '/simple.txt';
        $this->reset();
        $this->writer = new StaticFileWriter(sys_get_temp_dir() . '/simple');
    }

    #[Override]
    protected function tearDown(): void
    {
        $this->reset();
    }

    private function reset(): void
    {
        if (file_exists($this->file)) {
            unlink($this->file);
        }
    }

    public function testWritesToStaticFile(): void
    {
        self::assertFileDoesNotExist($this->file);

        $this->writer->write('foo', '.txt');

        self::assertFileExists($this->file);
    }

    public function testSetsMinimalPermissions(): void
    {
        $this->writer->write('foo', '.txt');

        self::assertSame(0400, fileperms($this->file) & 0700);
    }
}
