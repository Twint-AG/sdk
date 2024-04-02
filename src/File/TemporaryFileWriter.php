<?php

declare(strict_types=1);

namespace Twint\Sdk\File;

use Twint\Sdk\Exception\Timeout;
use Twint\Sdk\Factory\DefaultRandomStringFactory;
use Twint\Sdk\Util\Resilience;
use Twint\Sdk\Value\File;
use Webimpress\SafeWriter\FileWriter as SafeFileWriter;
use function Psl\invariant;
use function Psl\Type\non_empty_string;

/**
 * @phpstan-import-type Length from DefaultRandomStringFactory
 */
final class TemporaryFileWriter implements FileWriter
{
    private readonly File $baseDirectory;

    /**
     * @var list<File>
     */
    private array $files = [];

    private bool $shutdownRegistered = false;

    /**
     * @param callable(Length): string $createRandomString
     */
    public function __construct(
        ?File $baseDirectory = null,
        private readonly string $prefix = 'twint-sdk-',
        private readonly mixed $createRandomString = new DefaultRandomStringFactory()
    ) {
        $this->baseDirectory = $baseDirectory ?? new File(non_empty_string()->assert(sys_get_temp_dir()));
    }

    /**
     * @throws Timeout
     */
    public function write(string $input, string $extension = ''): File
    {
        return Resilience::retry(5, function () use ($input, $extension): File {
            $path = $this->baseDirectory . '/' . $this->prefix . ($this->createRandomString)(32) . $extension;

            invariant(!file_exists($path), 'File already exists: %s', $path);
            SafeFileWriter::writeFile($path, $input, 0400);

            $file = new File($path);

            $this->scheduleFlush($file);

            return $file;
        });
    }

    public function flush(): void
    {
        foreach ($this->files as $file) {
            @unlink((string) $file);
        }
    }

    private function scheduleFlush(File $file): void
    {
        $this->files[] = $file;

        if (!$this->shutdownRegistered) {
            register_shutdown_function(fn () => $this->flush());
            $this->shutdownRegistered = true;
        }
    }
}
