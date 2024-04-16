<?php

declare(strict_types=1);

namespace Twint\Sdk\Io;

final class ProcessingStream implements Stream
{
    /**
     * @param callable(string):string $processor
     */
    public function __construct(
        private readonly Stream $stream,
        private readonly mixed $processor
    ) {
    }

    public function read(): string
    {
        return ($this->processor)($this->stream->read());
    }
}
