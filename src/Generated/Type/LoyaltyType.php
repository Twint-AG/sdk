<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

class LoyaltyType
{
    protected string $Program;

    protected string $Reference;

    protected string $ExtendedReferenceDescription;

    public function getProgram(): string
    {
        return $this->Program;
    }

    public function withProgram(string $Program): static
    {
        $new = clone $this;
        $new->Program = $Program;

        return $new;
    }

    public function getReference(): string
    {
        return $this->Reference;
    }

    public function withReference(string $Reference): static
    {
        $new = clone $this;
        $new->Reference = $Reference;

        return $new;
    }

    public function getExtendedReferenceDescription(): string
    {
        return $this->ExtendedReferenceDescription;
    }

    public function withExtendedReferenceDescription(string $ExtendedReferenceDescription): static
    {
        $new = clone $this;
        $new->ExtendedReferenceDescription = $ExtendedReferenceDescription;

        return $new;
    }
}
