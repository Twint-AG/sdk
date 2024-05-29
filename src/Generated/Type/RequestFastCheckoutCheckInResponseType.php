<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use Phpro\SoapClient\Type\ResultInterface;

class RequestFastCheckoutCheckInResponseType implements ResultInterface
{
    protected CheckInNotificationType $CheckInNotification;

    /**
     * TWINT Token Type transports tokens used throughout the TWINT System. It separates the same information
     *  into three different elements to cater for different needs:
     *  - DisplayToken transports a Token formatted fit for display to a Human and subsequent manual entry. It may omit
     *  certain data only relevant in machine-machine communication or be formatted for better readability.
     *  - APIToken transports a Token formatted fit for passing on to another Application in an API Call. It is optimized
     *  for Transport of Data between applications.
     *  - QRCodeImage transports a token encoded in an QR-Code image. The image is provided as PNG Image sent as
     *  base64 encoded String within an DataURI, as defined in https://tools.ietf.org/html/rfc2397[RFC 2397]
     */
    protected TWINTTokenType $Token;

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

    public function getToken(): TWINTTokenType
    {
        return $this->Token;
    }

    public function withToken(TWINTTokenType $Token): static
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
