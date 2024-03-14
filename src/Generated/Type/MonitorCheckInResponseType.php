<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use Phpro\SoapClient\Type\ResultInterface;

class MonitorCheckInResponseType implements ResultInterface
{
    protected CheckInNotificationType $CheckInNotification;

    public function getCheckInNotification(): CheckInNotificationType
    {
        return $this->CheckInNotification;
    }

    public function withCheckInNotification(CheckInNotificationType $CheckInNotification): static
    {
        $new = clone $this;
        $new->CheckInNotification = $CheckInNotification;

        return $new;
    }
}
