<?php

declare(strict_types=1);

namespace Twint\Sdk\InvocationRecorder\Value;

final class SoapResponse
{
    public function __construct(
        private readonly string $body
    ) {
    }

    public function body(): string
    {
        return $this->body;
    }
}
