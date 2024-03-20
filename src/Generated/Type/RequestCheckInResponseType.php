<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use Phpro\SoapClient\Type\ResultInterface;

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

    public function withCheckInNotification(CheckInNotificationType $CheckInNotification): self
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

    public function withToken(int $Token): self
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

    public function withQRCode(string $QRCode): self
    {
        $new = clone $this;
        $new->QRCode = $QRCode;

        return $new;
    }
}
