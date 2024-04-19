<?php

declare(strict_types=1);

namespace Twint\Sdk\Io;

use Override;
use Throwable;
use Twint\Sdk\Exception\IoError;
use Twint\Sdk\Value\ExistingPath;
use Webimpress\SafeWriter\FileWriter as SafeFileWriter;

final class ContentSensitiveFileWriter implements FileWriter
{
    /**
     * @param callable(string): string $toFilename
     */
    public function __construct(
        private readonly ExistingPath $baseDirectory,
        private readonly mixed $toFilename
    ) {
    }

    /**
     * @param non-empty-string $baseDirectory
     * @param callable(string): string $toFilename
     */
    public static function fromBaseDirectory(string $baseDirectory, callable $toFilename): self
    {
        return new self(new ExistingPath($baseDirectory), $toFilename);
    }

    /**
     * @throws IoError
     */
    #[Override]
    public function write(string $input, string $extension = ''): ExistingPath
    {
        $fileName = $this->baseDirectory . '/' . ($this->toFilename)($input) . $extension;
        if (file_exists($fileName)) {
            return new ExistingPath($fileName);
        }

        try {
            SafeFileWriter::writeFile($fileName, $input, 0400);
        } catch (Throwable $e) {
            throw new IoError(sprintf('Failed to write file "%s"', $fileName), 0, $e);
        }

        return new ExistingPath($fileName);
    }
}
