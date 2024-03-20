<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

final class CodeValueType
{
    /**
     * @var string
     */
    private $_;

    /**
     * @var int
     */
    private $code;

    /**
     * @return string
     */
    public function get_()
    {
        return $this->_;
    }

    public function with_(string $_): self
    {
        $new = clone $this;
        $new->_ = $_;

        return $new;
    }

    /**
     * @return int
     */
    public function getCode()
    {
        return $this->code;
    }

    public function withCode(int $code): self
    {
        $new = clone $this;
        $new->code = $code;

        return $new;
    }
}
