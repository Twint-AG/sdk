<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use AllowDynamicProperties;
use Phpro\SoapClient\Type\ResultInterface;

#[AllowDynamicProperties]
final class CheckSystemStatusResponseType implements ResultInterface
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

    /**
     * @param string $Status
     * @return CheckSystemStatusResponseType
     */
    public function withStatus($Status)
    {
        $new = clone $this;
        $new->Status = $Status;

        return $new;
    }
}
