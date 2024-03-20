<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

final class BaseFault
{
    /**
     * @var ErrorCode
     */
    private $ErrorCode;

    /**
     * @return ErrorCode
     */
    public function getErrorCode()
    {
        return $this->ErrorCode;
    }

    public function withErrorCode(ErrorCode $ErrorCode): self
    {
        $new = clone $this;
        $new->ErrorCode = $ErrorCode;

        return $new;
    }
}
