<?php

declare(strict_types=1);

namespace Twint\Sdk\Certificate;

use Twint\Sdk\File\FileWriter;

interface Certificate
{
    public function content(): string;

    public function passphrase(): string;

    public function toFile(FileWriter $writer): FileStream;
}
