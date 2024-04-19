<?php

declare(strict_types=1);

namespace Twint\Sdk\Io;

use Override;
use Twint\Sdk\Exception\Timeout;
use Twint\Sdk\Factory\DefaultRandomStringFactory;
use Twint\Sdk\Util\Resilience;
use Twint\Sdk\Value\ExistingPath;
use Webimpress\SafeWriter\FileWriter as SafeFileWriter;
use function Psl\invariant;
use function Psl\Type\non_empty_string;

/**
 * @phpstan-import-type Length from DefaultRandomStringFactory
 */
final class TemporaryFileWriter implements FileWriter
{
    private readonly ExistingPath $baseDirectory;

    /**
     * @var list<ExistingPath>
     */
    private array $files = [];

    private bool $shutdownRegistered = false;

    /**
     * @param callable(Length): string $createRandomString
     */
    public function __construct(
        ?ExistingPath $baseDirectory = null,
        private readonly string $prefix = 'twint-sdk-',
        private readonly mixed $createRandomString = new DefaultRandomStringFactory()
    ) {
        $this->baseDirectory = $baseDirectory ?? new ExistingPath(non_empty_string()->assert(sys_get_temp_dir()));
    }

    /**
     * @throws Timeout
     */
    #[Override]
    public function write(string $input, string $extension = ''): ExistingPath
    {
        return Resilience::retry(5, function () use ($input, $extension): ExistingPath {
            $path = $this->baseDirectory . '/' . $this->prefix . ($this->createRandomString)(32) . $extension;

            invariant(!file_exists($path), 'File already exists: %s', $path);
            SafeFileWriter::writeFile($path, $input, 0400);

            $file = new ExistingPath($path);

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

    private function scheduleFlush(ExistingPath $file): void
    {
        $this->files[] = $file;

        if (!$this->shutdownRegistered) {
            register_shutdown_function(fn () => $this->flush());
            $this->shutdownRegistered = true;
        }
    }
}
