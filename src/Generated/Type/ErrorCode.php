<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

class ErrorCode
{
    protected string $Code;

    protected string $Status;

    protected ?string $DetailCode = null;

    protected ?string $DetailDescription = null;

    public function getCode(): string
    {
        return $this->Code;
    }

    public function withCode(string $Code): static
    {
        $new = clone $this;
        $new->Code = $Code;

        return $new;
    }

    public function getStatus(): string
    {
        return $this->Status;
    }

    public function withStatus(string $Status): static
    {
        $new = clone $this;
        $new->Status = $Status;

        return $new;
    }

    public function getDetailCode(): ?string
    {
        return $this->DetailCode;
    }

    public function withDetailCode(?string $DetailCode): static
    {
        $new = clone $this;
        $new->DetailCode = $DetailCode;

        return $new;
    }

    public function getDetailDescription(): ?string
    {
        return $this->DetailDescription;
    }

    public function withDetailDescription(?string $DetailDescription): static
    {
        $new = clone $this;
        $new->DetailDescription = $DetailDescription;

        return $new;
    }
}
