<?php

declare(strict_types=1);

namespace Twint\Sdk\Io;

use Override;
use function Psl\Type\non_empty_string;

/**
 * @template-implements Stream<non-empty-string>
 */
final class NonEmptyStream implements Stream
{
    /**
     * @param Stream<string> $stream
     */
    public function __construct(
        private readonly Stream $stream
    ) {
    }

    #[Override]
    public function read(): string
    {
        return non_empty_string()->assert($this->stream->read());
    }
}
