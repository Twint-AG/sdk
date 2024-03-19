<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use AllowDynamicProperties;
use Phpro\SoapClient\Type\ResultInterface;

#[AllowDynamicProperties]
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

    /**
     * @param CheckInNotificationType $CheckInNotification
     * @return MonitorCheckInResponseType
     */
    public function withCheckInNotification($CheckInNotification)
    {
        $new = clone $this;
        $new->CheckInNotification = $CheckInNotification;

        return $new;
    }
}
