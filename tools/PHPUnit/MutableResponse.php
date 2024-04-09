<?php

declare(strict_types=1);

namespace Twint\Sdk\Tools\PHPUnit;

use VCR\Response;

final class MutableResponse
{
    public function __construct(
        private readonly Response $response
    ) {
    }

    public function setStatus(int $status): void
    {
        (function (int $status) {
            $this->setStatus((string) $status);
        })->call($this->response, $status);
    }

    public function setBody(?string $body): void
    {
        (function (?string $body) {
            $this->body = $body;
        })->call($this->response, $body);
    }

    public function setHeader(string $name, string $value): void
    {
        (function (string $name, string $value) {
            $this->headers[$name] = $value;
        })->call($this->response, $name, $value);
    }

    public function unsetHeader(string $name): void
    {
        (function (string $name) {
            unset($this->headers[$name]);
        })->call($this->response, $name);
    }
}
