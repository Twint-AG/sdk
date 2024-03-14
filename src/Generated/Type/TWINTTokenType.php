<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

class TWINTTokenType
{
    protected string $DisplayToken;

    protected string $APIToken;

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
