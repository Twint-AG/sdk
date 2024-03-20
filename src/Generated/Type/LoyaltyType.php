<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

final class LoyaltyType
{
    /**
     * @var string
     */
    private $Program;

    /**
     * @var string
     */
    private $Reference;

    /**
     * @var string
     */
    private $ExtendedReferenceDescription;

    /**
     * @return string
     */
    public function getProgram()
    {
        return $this->Program;
    }

    public function withProgram(string $Program): self
    {
        $new = clone $this;
        $new->Program = $Program;

        return $new;
    }

    /**
     * @return string
     */
    public function getReference()
    {
        return $this->Reference;
    }

    public function withReference(string $Reference): self
    {
        $new = clone $this;
        $new->Reference = $Reference;

        return $new;
    }

    /**
     * @return string
     */
    public function getExtendedReferenceDescription()
    {
        return $this->ExtendedReferenceDescription;
    }

    public function withExtendedReferenceDescription(string $ExtendedReferenceDescription): self
    {
        $new = clone $this;
        $new->ExtendedReferenceDescription = $ExtendedReferenceDescription;

        return $new;
    }
}
