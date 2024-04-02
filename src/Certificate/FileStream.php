<?php

declare(strict_types=1);

namespace Twint\Sdk\Certificate;

use SensitiveParameter;
use Twint\Sdk\Value\File;
use function Psl\File\read;

final class FileStream implements Stream
{
    public function __construct(
        #[SensitiveParameter]
        private readonly File $file
    ) {
    }

    public function read(): string
    {
        return read((string) $this->file);
    }

    public function path(): File
    {
        return $this->file;
    }
}
