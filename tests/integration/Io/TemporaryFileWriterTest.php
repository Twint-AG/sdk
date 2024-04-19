<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Integration\Io;

use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Twint\Sdk\Factory\DefaultRandomStringFactory;
use Twint\Sdk\Io\TemporaryFileWriter;
use Twint\Sdk\Value\ExistingPath;

/**
 * @internal
 */
#[CoversClass(TemporaryFileWriter::class)]
final class TemporaryFileWriterTest extends TestCase
{
    private readonly TemporaryFileWriter $fileWriter;

    #[Override]
    protected function setUp(): void
    {
        $this->fileWriter = new TemporaryFileWriter();
    }

    public function testCreatesTemporaryFile(): void
    {
        $file = $this->fileWriter->write('test', '.foo');

        self::assertFileExists((string) $file);
        self::assertStringEqualsFile((string) $file, 'test');
        self::assertStringEndsWith('.foo', (string) $file);
    }

    public function testDeletesTemporaryFile(): void
    {
        $file = $this->fileWriter->write('test', '.foo');
        $path = (string) $file;

        self::assertFileExists($path);

        $this->fileWriter->flush();

        self::assertFileDoesNotExist($path);
    }

    public function testDetectsExistingFile(): void
    {
        $tempDir = __DIR__ . '/../../../build/tmp-file-writer-' . (new DefaultRandomStringFactory())(32);
        mkdir($tempDir, 0700, true);

        $count = 0;

        $fileWriter = new TemporaryFileWriter(
            new ExistingPath($tempDir),
            'test-',
            static function () use (&$count): string {
                return $count++ === 0 ? 'a' : 'b';
            }
        );

        // Generate conflict
        touch($tempDir . '/test-a.ext');

        $file = $fileWriter->write('test', '.ext');

        self::assertStringEndsWith('/test-b.ext', (string) $file);
    }

    public function testSetsMinimalPermissions(): void
    {
        $file = $this->fileWriter->write('test', '.foo');

        self::assertSame(0400, fileperms((string) $file) & 0700);
    }
}
