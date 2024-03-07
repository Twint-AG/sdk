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

    /**
     * @param ErrorCode $ErrorCode
     * @return BaseFault
     */
    public function withErrorCode($ErrorCode)
    {
        $new = clone $this;
        $new->ErrorCode = $ErrorCode;

        return $new;
    }
}
