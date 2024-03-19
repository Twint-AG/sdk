<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use AllowDynamicProperties;
use Phpro\SoapClient\Type\ResultInterface;

#[AllowDynamicProperties]
final class RequestCheckInResponseType implements ResultInterface
{
    /**
     * @var CheckInNotificationType
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
     * @return CheckInNotificationType
     */
    public function getCheckInNotification()
    {
        return $this->CheckInNotification;
    }

    /**
     * @param CheckInNotificationType $CheckInNotification
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
