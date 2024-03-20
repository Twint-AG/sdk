<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

final class BNPLDataType
{
    /**
     * @var string
     */
    private $ProductCode;

    /**
     * @return string
     */
    public function getProductCode()
    {
        return $this->ProductCode;
    }

    public function withProductCode(string $ProductCode): self
    {
        $new = clone $this;
        $new->ProductCode = $ProductCode;

        return $new;
    }
}
