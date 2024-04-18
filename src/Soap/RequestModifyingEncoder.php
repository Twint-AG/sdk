<?php

declare(strict_types=1);

namespace Twint\Sdk\Soap;

use Override;
use Soap\Engine\Encoder;
use Soap\Engine\HttpBinding\SoapRequest;

final class RequestModifyingEncoder implements Encoder
{
    /**
     * @param callable(SoapRequest, string, array<mixed>): SoapRequest $modifier
     */
    public function __construct(
        private readonly Encoder $wrapped,
        private readonly mixed $modifier
    ) {
    }

    /**
     * @param array<mixed> $arguments
     */
    #[Override]
    public function encode(string $method, array $arguments): SoapRequest
    {
        return ($this->modifier)($this->wrapped->encode($method, $arguments), $method, $arguments);
    }
}
