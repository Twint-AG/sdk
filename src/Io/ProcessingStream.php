<?php

declare(strict_types=1);

namespace Twint\Sdk\Io;

use Override;

/**
 * @template TInner of string
 * @template TOuter of string
 * @template-implements Stream<TOuter>
 */
final class ProcessingStream implements Stream
{
    /**
     * @param Stream<TInner> $stream
     * @param callable(TInner):TOuter $processor
     */
    public function __construct(
        private readonly Stream $stream,
        private readonly mixed $processor
    ) {
    }

    #[Override]
    public function read(): string
    {
        return ($this->processor)($this->stream->read());
    }
}
