<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use Phpro\SoapClient\Type\ResultInterface;

class CancelCheckInResponseType implements ResultInterface
{
    /**
     * @var 'OK' | 'ERROR'
     */
    protected string $Status;

    /**
     * @return 'OK' | 'ERROR'
     */
    public function getStatus(): string
    {
        return $this->Status;
    }

    /**
     * @param 'OK' | 'ERROR' $Status
     */
    public function withStatus(string $Status): static
    {
        $new = clone $this;
        $new->Status = $Status;

        return $new;
    }
}
