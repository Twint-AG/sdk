<?php

declare(strict_types=1);

namespace Twint\Sdk\Certificate;

use Twint\Sdk\Io\FileStream;
use Twint\Sdk\Io\FileWriter;

interface Certificate
{
    /**
     * @return non-empty-string
     */
    public function content(): string;

    /**
     * @return non-empty-string
     */
    public function passphrase(): string;

    public function toFile(FileWriter $writer): FileStream;
}
