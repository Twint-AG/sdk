<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use Phpro\SoapClient\Type\ResultInterface;

class IsUofConnectionActiveResponseType implements ResultInterface
{
    protected bool $active;

    public function getActive(): bool
    {
        return $this->active;
    }

    public function withActive(bool $active): static
    {
        $new = clone $this;
        $new->active = $active;

        return $new;
    }
}
