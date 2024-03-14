<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

class CodeValueType
{
    protected string $_;

    protected int $code;

    public function get_(): string
    {
        return $this->_;
    }

    public function with_(string $_): static
    {
        $new = clone $this;
        $new->_ = $_;

        return $new;
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function withCode(int $code): static
    {
        $new = clone $this;
        $new->code = $code;

        return $new;
    }
}
