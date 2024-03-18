<?php

declare(strict_types=1);

namespace Twint\Sdk\Factory;

use Twint\Sdk\Value\File;

final class StaticFileFactory
{
    public function __construct(
        private readonly File $file
    ) {
    }

    public function __invoke(): File
    {
        return $this->file;
    }
}
