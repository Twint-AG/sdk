<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

class BaseFault
{
    protected ErrorCode $ErrorCode;

    public function getErrorCode(): ErrorCode
    {
        return $this->ErrorCode;
    }

    public function withErrorCode(ErrorCode $ErrorCode): static
    {
        $new = clone $this;
        $new->ErrorCode = $ErrorCode;

        return $new;
    }
}
