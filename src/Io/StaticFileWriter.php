<?php

declare(strict_types=1);

namespace Twint\Sdk\Io;

use Override;
use Throwable;
use Twint\Sdk\Exception\IoError;
use Twint\Sdk\Value\ExistingPath;
use Webimpress\SafeWriter\FileWriter as SafeFileWriter;

final class StaticFileWriter implements FileWriter
{
    /**
     * @param non-empty-string $base
     */
    public function __construct(
        private readonly string $base
    ) {
    }

    /**
     * @throws IoError
     */
    #[Override]
    public function write(string $input, string $extension = ''): ExistingPath
    {
        $fileName = $this->base . $extension;

        try {
            SafeFileWriter::writeFile($fileName, $input, 0400);
        } catch (Throwable $e) {
            throw new IoError(sprintf('Failed to write file "%s"', $fileName), 0, $e);
        }

        return new ExistingPath($fileName);
    }
}
