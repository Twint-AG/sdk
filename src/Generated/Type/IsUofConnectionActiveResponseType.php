<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use Phpro\SoapClient\Type\ResultInterface;

final class IsUofConnectionActiveResponseType implements ResultInterface
{
    /**
     * @var bool
     */
    private $active;

    /**
     * @return bool
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param bool $active
     * @return IsUofConnectionActiveResponseType
     */
    public function withActive($active)
    {
        $new = clone $this;
        $new->active = $active;

        return $new;
    }
}
