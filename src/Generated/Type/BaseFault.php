<?php

namespace Twint\Sdk\Generated\Type;

class BaseFault
{
    /**
     * @var \Twint\Sdk\Generated\Type\ErrorCode
     */
    private $ErrorCode;

    /**
     * @return \Twint\Sdk\Generated\Type\ErrorCode
     */
    public function getErrorCode()
    {
        return $this->ErrorCode;
    }

    /**
     * @param \Twint\Sdk\Generated\Type\ErrorCode $ErrorCode
     * @return BaseFault
     */
    public function withErrorCode($ErrorCode)
    {
        $new = clone $this;
        $new->ErrorCode = $ErrorCode;

        return $new;
    }
}

