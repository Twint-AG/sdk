<?php

declare(strict_types=1);

namespace Twint\Sdk\Io;

use SensitiveParameter;

final class InMemoryStream implements Stream
{
    public function __construct(
        #[SensitiveParameter]
        private readonly string $content
    ) {
    }

    public function read(): string
    {
        return $this->content;
    }
}
