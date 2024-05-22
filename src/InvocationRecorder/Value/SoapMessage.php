<?php

declare(strict_types=1);

namespace Twint\Sdk\InvocationRecorder\Value;

use Throwable;

final class SoapMessage
{
    private function __construct(
        private readonly SoapRequest $request,
        private readonly ?SoapResponse $response,
        private readonly ?Throwable $exception
    ) {
    }

    public static function fromException(SoapRequest $request, Throwable $fault): self
    {
        return new self($request, null, $fault);
    }

    public static function fromResponse(SoapRequest $request, SoapResponse $response): self
    {
        return new self($request, $response, null);
    }

    public function request(): SoapRequest
    {
        return $this->request;
    }

    public function response(): ?SoapResponse
    {
        return $this->response;
    }

    /**
     * @phpstan-assert-if-true null $this->response()
     * @phpstan-assert-if-true !null $this->exception()
     */
    public function threwException(): bool
    {
        return $this->exception !== null;
    }

    public function exception(): ?Throwable
    {
        return $this->exception;
    }
}
