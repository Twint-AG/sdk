<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

final class MerchantId
{
    public function __construct(
        private string $id
    ) {
        // @todo: UUID validation
        $this->id = $id;
    }

    public function __toString(): string
    {
        return $this->id;
    }
}
