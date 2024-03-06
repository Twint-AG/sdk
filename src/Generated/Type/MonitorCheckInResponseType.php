<?php

namespace Twint\Sdk\Generated\Type;

use Phpro\SoapClient\Type\ResultInterface;

class MonitorCheckInResponseType implements ResultInterface
{
    /**
     * @var \Twint\Sdk\Generated\Type\CheckInNotificationType
     */
    private $CheckInNotification;

    /**
     * @return \Twint\Sdk\Generated\Type\CheckInNotificationType
     */
    public function getCheckInNotification()
    {
        return $this->CheckInNotification;
    }

    /**
     * @param \Twint\Sdk\Generated\Type\CheckInNotificationType $CheckInNotification
     * @return MonitorCheckInResponseType
     */
    public function withCheckInNotification($CheckInNotification)
    {
        $new = clone $this;
        $new->CheckInNotification = $CheckInNotification;

        return $new;
    }
}

