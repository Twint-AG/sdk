<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

class KeyValueType
{
    protected string $_;

    protected string $key;

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

    public function getKey(): string
    {
        return $this->key;
    }

    public function withKey(string $key): static
    {
        $new = clone $this;
        $new->key = $key;

        return $new;
    }
}
