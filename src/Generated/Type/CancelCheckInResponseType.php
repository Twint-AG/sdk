<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use Phpro\SoapClient\Type\ResultInterface;

final class CancelCheckInResponseType implements ResultInterface
{
    /**
     * @var string
     */
    private $Status;

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
}
