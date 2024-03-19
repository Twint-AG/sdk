<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use AllowDynamicProperties;

#[AllowDynamicProperties]
final class BNPLDataType
{
    /**
     * @var string
     */
    private $ProductCode;

    /**
     * @return string
     */
    public function getProductCode()
    {
        return $this->ProductCode;
    }

    /**
     * @param string $ProductCode
     * @return BNPLDataType
     */
    public function withProductCode($ProductCode)
    {
        $new = clone $this;
        $new->ProductCode = $ProductCode;

        return $new;
    }
}
