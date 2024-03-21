<?php

declare(strict_types=1);

namespace Twint\Sdk\Certificate;

interface Stream
{
    public function read(): string;
}
