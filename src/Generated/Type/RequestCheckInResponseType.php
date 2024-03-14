<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use Phpro\SoapClient\Type\ResultInterface;

class RequestCheckInResponseType implements ResultInterface
{
    protected CheckInNotificationType $CheckInNotification;

    protected ?int $Token;

    protected ?string $QRCode;

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

    public function getToken(): ?int
    {
        return $this->Token;
    }

    public function withToken(?int $Token): static
    {
        $new = clone $this;
        $new->Token = $Token;

        return $new;
    }

    public function getQRCode(): ?string
    {
        return $this->QRCode;
    }

    public function withQRCode(?string $QRCode): static
    {
        $new = clone $this;
        $new->QRCode = $QRCode;

        return $new;
    }
}
