<?php

declare(strict_types=1);

namespace Twint\Sdk\File;

use Throwable;
use Twint\Sdk\Exception\AssertionFailed;
use Twint\Sdk\Exception\IoError;
use Twint\Sdk\Value\File;
use Webimpress\SafeWriter\FileWriter as SafeFileWriter;

final class ContentSensitiveFileWriter implements FileWriter
{
    /**
     * @param callable(string): string $toFilename
     */
    public function __construct(
        private readonly File $baseDirectory,
        private mixed $toFilename
    ) {
    }

    /**
     * @param non-empty-string $baseDirectory
     * @param callable(string): string $toFilename
     * @throws AssertionFailed
     */
    public static function fromBaseDirectory(string $baseDirectory, callable $toFilename): self
    {
        return new self(new File($baseDirectory), $toFilename);
    }

    /**
     * @throws IoError
     * @throws AssertionFailed
     */
    public function write(string $input, string $extension = ''): File
    {
        $fileName = $this->baseDirectory . '/' . ($this->toFilename)($input) . $extension;
        if (file_exists($fileName)) {
            return new File($fileName);
        }

        try {
            SafeFileWriter::writeFile($fileName, $input);
        } catch (Throwable $e) {
            throw new IoError(sprintf('Failed to write file "%s"', $fileName), 0, $e);
        }

        return new File($fileName);
    }
}
