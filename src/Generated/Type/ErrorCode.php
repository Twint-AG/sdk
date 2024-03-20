<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

final class ErrorCode
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

    public function withCode(string $Code): self
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

    public function withStatus(string $Status): self
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

    public function withDetailCode(string $DetailCode): self
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

    public function withDetailDescription(string $DetailDescription): self
    {
        $new = clone $this;
        $new->DetailDescription = $DetailDescription;

        return $new;
    }
}
