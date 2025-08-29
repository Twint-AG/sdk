<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Integration\Diagnostics;

use FilesystemIterator;
use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Path;
use Twint\Sdk\Diagnostics\Collector;
use Twint\Sdk\Io\TemporaryFileWriter;
use ZipArchive;
use function Psl\Type\instance_of;
use function Psl\Type\non_empty_string;
use function Psl\Type\string;

/**
 * @internal
 */
#[CoversClass(Collector::class)]
final class CollectorTest extends TestCase
{
    private readonly string $tempDir;

    private readonly string $archivePath;

    private readonly string $archiveDir;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->tempDir = sys_get_temp_dir() . '/twint-sdk-tests/' . bin2hex(random_bytes(8));
        (new Filesystem())->mkdir($this->tempDir);
        $this->archivePath = $this->tempDir . '/diagnostics.zip';
        $this->archiveDir = $this->tempDir . '/extracted';
    }

    #[Override]
    protected function tearDown(): void
    {
        parent::tearDown();
        (new Filesystem())->remove($this->tempDir);
    }

    public function testBasicDiagnosticsCollection(): void
    {
        $collector = new Collector();

        $collector
            ->includePath(__DIR__)
            ->includePath(non_empty_string()->assert(Path::join(__DIR__, '..')), static fn () => false)
            ->includePath(non_empty_string()->assert(Path::join(__DIR__, '..', 'InvocationRecorder')))
            ->includePath('does/not/exist')
            ->includeInsight('Test key 1', 'Test value 1')
            ->includeInsight('Test key 2', 'Test value 2')
            ->collect(
                'foo',
                function ($data) {
                    file_put_contents($this->archivePath, $data, FILE_APPEND);
                },
                static function () {}
            );

        $this->extractArchive();

        self::assertSame(
            [
                'diagnostics.log',
                'environment.json',
                'tests/integration/Diagnostics/CollectorTest.php',
                'tests/integration/InvocationRecorder/InvocationRecordingClientTest.php',
            ],
            self::normalizedFileListing($this->archiveDir)
        );
        self::assertJsonStringEqualsJsonString(
            json_encode(
                [['Test key 1', 'Test value 1'], ['Test key 2', 'Test value 2']],
                JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR
            ),
            non_empty_string()
                ->assert(file_get_contents($this->archiveDir . '/environment.json'))
        );
        self::assertFileMatchesFormat(
            <<<'EOS'
Added file "%sCollectorTest.php" because no predicate given
Predicate evaluated false for file "%s.php"
%a
Predicate evaluated false for file "%s.php"
%a
Predicate evaluated false for file "%s.php"
Added file "%sInvocationRecordingClientTest.php" because no predicate given
Path "does/not/exist" was not found
EOS
            ,
            $this->archiveDir . '/diagnostics.log'
        );
    }

    public function testRaceConditionWithUnlink(): void
    {
        $file = (new TemporaryFileWriter())->write('foo');

        $collector = new Collector();
        $collector
            // @phpstan-ignore-next-line argument.type
            ->includePath((string) $file, static function (string $path) {
                unlink($path);
                return true;
            })
            ->collect(
                'foo',
                function ($data) {
                    file_put_contents($this->archivePath, $data, FILE_APPEND);
                },
                static function () {}
            );

        $this->extractArchive();

        self::assertFileMatchesFormat(
            <<<'EOS'
Failed to add file "%stwint-sdk-%s": "The file with the path %stwint-sdk-%s wasn't found."
EOS
            ,
            $this->archiveDir . '/diagnostics.log'
        );
    }

    /**
     * @return list<string>
     */
    private static function normalizedFileListing(string $dir): array
    {
        $files = [];

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS),
            RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($iterator as $fileinfo) {
            instance_of(SplFileInfo::class)->assert($fileinfo);

            $files[] = str_replace(
                substr(string()->assert(realpath(__DIR__ . '/../../../')), 1) . '/',
                '',
                str_replace($dir . '/', '', $fileinfo->getPathname())
            );
        }

        sort($files);

        return $files;
    }

    private function extractArchive(): void
    {
        $zip = new ZipArchive();
        $zip->open($this->archivePath);
        $zip->extractTo($this->archiveDir);
    }
}
