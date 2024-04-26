<?php

declare(strict_types=1);

namespace Twint\Sdk\Io;

use Override;
use SensitiveParameter;

/**
 * @template T of string
 * @template-implements Stream<T>
 */
final class InMemoryStream implements Stream
{
    /**
     * @param T $content
     */
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
