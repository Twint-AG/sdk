<?php

namespace Twint\Sdk\Generated\Type;

class LoyaltyType
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

    /**
     * @param string $Program
     * @return LoyaltyType
     */
    public function withProgram($Program)
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

    /**
     * @param string $Reference
     * @return LoyaltyType
     */
    public function withReference($Reference)
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

    /**
     * @param string $ExtendedReferenceDescription
     * @return LoyaltyType
     */
    public function withExtendedReferenceDescription($ExtendedReferenceDescription)
    {
        $new = clone $this;
        $new->ExtendedReferenceDescription = $ExtendedReferenceDescription;

        return $new;
    }
}

