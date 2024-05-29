<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

class TWINTTokenType
{
    protected string $DisplayToken;

    protected string $APIToken;

    /**
     * DataUriScheme allows transporting an image or other binary Data in a format that is fit to be placed inside
     *  an 'img' element in a website as inline image definition. Such an Element always starts with the word 'data:' and
     *  then contains the contents of the image in Base64 encoded form (see https://tools.ietf.org/html/rfc2397[RFC 2397])
     *  Within TWINT this Datatype is usually used to transport QR-Code Images in PNG Format.
     */
    protected string $QRCodeImage;

    public function getDisplayToken(): string
    {
        return $this->DisplayToken;
    }

    public function withDisplayToken(string $DisplayToken): static
    {
        $new = clone $this;
        $new->DisplayToken = $DisplayToken;

        return $new;
    }

    public function getAPIToken(): string
    {
        return $this->APIToken;
    }

    public function withAPIToken(string $APIToken): static
    {
        $new = clone $this;
        $new->APIToken = $APIToken;

        return $new;
    }

    public function getQRCodeImage(): string
    {
        return $this->QRCodeImage;
    }

    public function withQRCodeImage(string $QRCodeImage): static
    {
        $new = clone $this;
        $new->QRCodeImage = $QRCodeImage;

        return $new;
    }
}
