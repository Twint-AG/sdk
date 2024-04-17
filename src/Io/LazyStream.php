<?php

declare(strict_types=1);

namespace Twint\Sdk\Io;

final class LazyStream implements Stream
{
    private readonly ?string $content;

    public function __construct(
        private readonly Stream $stream
    ) {
    }

    public function read(): string
    {
        return $this->content ??= $this->stream->read();
    }
}
