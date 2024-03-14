<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

class BNPLDataType
{
    /**
     * The associated code of the BNPL-product. Format: "^\w{1,8}$"
     */
    protected string $ProductCode;

    public function getProductCode(): string
    {
        return $this->ProductCode;
    }

    public function withProductCode(string $ProductCode): static
    {
        $new = clone $this;
        $new->ProductCode = $ProductCode;

        return $new;
    }
}
