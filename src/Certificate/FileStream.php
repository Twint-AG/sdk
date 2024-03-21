<?php

declare(strict_types=1);

namespace Twint\Sdk\Certificate;

use SensitiveParameter;
use Twint\Sdk\Assertion;
use Twint\Sdk\Exception\AssertionFailed;
use Twint\Sdk\Value\File;

final class FileStream implements Stream
{
    public function __construct(
        #[SensitiveParameter]
        private readonly File $file
    ) {
    }

    /**
     * @throws AssertionFailed
     */
    public function read(): string
    {
        $content = file_get_contents((string) $this->file);

        Assertion::string($content, 'Failed to read file content');

        return $content;
    }

    public function path(): File
    {
        return $this->file;
    }
}
