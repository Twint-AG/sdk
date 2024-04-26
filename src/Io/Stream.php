<?php

declare(strict_types=1);

namespace Twint\Sdk\Io;

/**
 * @template-covariant T of string
 */
interface Stream
{
    /**
     * @return T
     */
    public function read(): string;
}
