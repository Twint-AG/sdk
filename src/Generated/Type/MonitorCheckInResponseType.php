<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use Phpro\SoapClient\Type\ResultInterface;

final class MonitorCheckInResponseType implements ResultInterface
{
    /**
     * @var CheckInNotificationType
     */
    private $CheckInNotification;

    /**
     * @return CheckInNotificationType
     */
    public function getCheckInNotification()
    {
        return $this->CheckInNotification;
    }

    public function withCheckInNotification(CheckInNotificationType $CheckInNotification): self
    {
        $new = clone $this;
        $new->CheckInNotification = $CheckInNotification;

        return $new;
    }
}
