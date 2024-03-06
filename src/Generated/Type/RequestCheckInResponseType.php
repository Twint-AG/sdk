<?php

namespace Twint\Sdk\Generated\Type;

use Phpro\SoapClient\Type\ResultInterface;

class RequestCheckInResponseType implements ResultInterface
{
    /**
     * @var \Twint\Sdk\Generated\Type\CheckInNotificationType
     */
    private $CheckInNotification;

    /**
     * @var int
     */
    private $Token;

    /**
     * @var string
     */
    private $QRCode;

    /**
     * @return \Twint\Sdk\Generated\Type\CheckInNotificationType
     */
    public function getCheckInNotification()
    {
        return $this->CheckInNotification;
    }

    /**
     * @param \Twint\Sdk\Generated\Type\CheckInNotificationType $CheckInNotification
     * @return RequestCheckInResponseType
     */
    public function withCheckInNotification($CheckInNotification)
    {
        $new = clone $this;
        $new->CheckInNotification = $CheckInNotification;

        return $new;
    }

    /**
     * @return int
     */
    public function getToken()
    {
        return $this->Token;
    }

    /**
     * @param int $Token
     * @return RequestCheckInResponseType
     */
    public function withToken($Token)
    {
        $new = clone $this;
        $new->Token = $Token;

        return $new;
    }

    /**
     * @return string
     */
    public function getQRCode()
    {
        return $this->QRCode;
    }

    /**
     * @param string $QRCode
     * @return RequestCheckInResponseType
     */
    public function withQRCode($QRCode)
    {
        $new = clone $this;
        $new->QRCode = $QRCode;

        return $new;
    }
}

