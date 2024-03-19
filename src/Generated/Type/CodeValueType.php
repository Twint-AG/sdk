<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use AllowDynamicProperties;

#[AllowDynamicProperties]
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

    /**
     * @param string $_
     * @return CodeValueType
     */
    public function with_($_)
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

    /**
     * @param int $code
     * @return CodeValueType
     */
    public function withCode($code)
    {
        $new = clone $this;
        $new->code = $code;

        return $new;
    }
}
