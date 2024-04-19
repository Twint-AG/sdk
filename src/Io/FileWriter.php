<?php

declare(strict_types=1);

namespace Twint\Sdk\Io;

use Twint\Sdk\Value\ExistingPath;

interface FileWriter
{
    public function write(string $input, string $extension = ''): ExistingPath;
}
