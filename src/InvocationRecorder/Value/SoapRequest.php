<?php

declare(strict_types=1);

namespace Twint\Sdk\InvocationRecorder\Value;

use Twint\Sdk\Value\Url;

final class SoapRequest
{
    public const VERSION_1_1 = 1;

    public const VERSION_1_2 = 2;

    public function __construct(
        private readonly Url $location,
        private readonly string $action,
        private readonly int $version,
        private readonly bool $oneWay,
        private readonly string $body
    ) {
    }

    public function location(): Url
    {
        return $this->location;
    }

    public function action(): string
    {
        return $this->action;
    }

    public function version(): int
    {
        return $this->version;
    }

    public function isSoap11(): bool
    {
        return $this->version === self::VERSION_1_1;
    }

    public function isSoap12(): bool
    {
        return $this->version === self::VERSION_1_2;
    }

    public function isOneWay(): bool
    {
        return $this->oneWay;
    }

    public function body(): string
    {
        return $this->body;
    }
}
