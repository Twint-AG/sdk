<?php

declare(strict_types=1);

namespace Twint\Sdk\Io;

use Twint\Sdk\Value\File;

interface FileWriter
{
    public function write(string $input, string $extension = ''): File;
}
