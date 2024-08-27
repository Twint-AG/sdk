<?php

declare(strict_types=1);

namespace Twint\Sdk\Io;

use Override;

/**
 * @template T of string
 * @template-implements Stream<T>
 */
final class LazyStream implements Stream
{
    /**
     * @var T
     */
    private readonly string $content;

    /**
     * @param Stream<T> $stream
     */
    public function __construct(
        private readonly Stream $stream
    ) {
    }

    #[Override]
    public function read(): string
    {
        return $this->content ??= $this->stream->read();
    }
}
