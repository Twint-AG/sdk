<?php

namespace Twint\Sdk\Generated\Type;

class ErrorCode
{
    /**
     * @var string
     */
    private $Code;

    /**
     * @var string
     */
    private $Status;

    /**
     * @var string
     */
    private $DetailCode;

    /**
     * @var string
     */
    private $DetailDescription;

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->Code;
    }

    /**
     * @param string $Code
     * @return ErrorCode
     */
    public function withCode($Code)
    {
        $new = clone $this;
        $new->Code = $Code;

        return $new;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->Status;
    }

    /**
     * @param string $Status
     * @return ErrorCode
     */
    public function withStatus($Status)
    {
        $new = clone $this;
        $new->Status = $Status;

        return $new;
    }

    /**
     * @return string
     */
    public function getDetailCode()
    {
        return $this->DetailCode;
    }

    /**
     * @param string $DetailCode
     * @return ErrorCode
     */
    public function withDetailCode($DetailCode)
    {
        $new = clone $this;
        $new->DetailCode = $DetailCode;

        return $new;
    }

    /**
     * @return string
     */
    public function getDetailDescription()
    {
        return $this->DetailDescription;
    }

    /**
     * @param string $DetailDescription
     * @return ErrorCode
     */
    public function withDetailDescription($DetailDescription)
    {
        $new = clone $this;
        $new->DetailDescription = $DetailDescription;

        return $new;
    }
}

