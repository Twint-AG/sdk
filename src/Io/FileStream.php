<?php

declare(strict_types=1);

namespace Twint\Sdk\Io;

use Override;
use SensitiveParameter;
use Twint\Sdk\Value\ExistingPath;
use function Psl\File\read;

final class FileStream implements Stream
{
    public function __construct(
        #[SensitiveParameter]
        private readonly ExistingPath $file
    ) {
    }

    #[Override]
    public function read(): string
    {
        return read((string) $this->file);
    }

    public function path(): ExistingPath
    {
        return $this->file;
    }
}
