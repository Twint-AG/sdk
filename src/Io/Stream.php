<?php

declare(strict_types=1);

namespace Twint\Sdk\Io;

interface Stream
{
    public function read(): string;
}
