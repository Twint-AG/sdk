<?php

declare(strict_types=1);

namespace Twint\Sdk\Factory;

use Twint\Sdk\Value\ExistingPath;

final class StaticFileFactory
{
    public function __construct(
        private readonly ExistingPath $file
    ) {
    }

    public function __invoke(): ExistingPath
    {
        return $this->file;
    }
}
