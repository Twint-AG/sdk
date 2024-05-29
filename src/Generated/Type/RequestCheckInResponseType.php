<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use Phpro\SoapClient\Type\ResultInterface;

class RequestCheckInResponseType implements ResultInterface
{
    protected CheckInNotificationType $CheckInNotification;

    protected ?int $Token = null;

    /**
     * DataUriScheme allows transporting an image or other binary Data in a format that is fit to be placed inside
     *  an 'img' element in a website as inline image definition. Such an Element always starts with the word 'data:' and
     *  then contains the contents of the image in Base64 encoded form (see https://tools.ietf.org/html/rfc2397[RFC 2397])
     *  Within TWINT this Datatype is usually used to transport QR-Code Images in PNG Format.
     */
    protected ?string $QRCode = null;

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
