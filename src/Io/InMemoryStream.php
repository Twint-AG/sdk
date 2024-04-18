<?php

declare(strict_types=1);

namespace Twint\Sdk\Io;

use Override;
use SensitiveParameter;

final class InMemoryStream implements Stream
{
    public function __construct(
        #[SensitiveParameter]
        private readonly string $content
    ) {
    }

    #[Override]
    public function read(): string
    {
        return $this->content;
    }
}
