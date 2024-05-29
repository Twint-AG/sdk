<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

class CustomerDataFieldType
{
    protected string $Name;

    protected string $Value;

    public function getName(): string
    {
        return $this->Name;
    }

    public function withName(string $Name): static
    {
        $new = clone $this;
        $new->Name = $Name;

        return $new;
    }

    public function getValue(): string
    {
        return $this->Value;
    }

    public function withValue(string $Value): static
    {
        $new = clone $this;
        $new->Value = $Value;

        return $new;
    }
}
