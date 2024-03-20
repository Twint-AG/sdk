<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

final class TWINTTokenType
{
    /**
     * @var string
     */
    private $DisplayToken;

    /**
     * @var string
     */
    private $APIToken;

    /**
     * @var string
     */
    private $QRCodeImage;

    /**
     * @return string
     */
    public function getDisplayToken()
    {
        return $this->DisplayToken;
    }

    public function withDisplayToken(string $DisplayToken): self
    {
        $new = clone $this;
        $new->DisplayToken = $DisplayToken;

        return $new;
    }

    /**
     * @return string
     */
    public function getAPIToken()
    {
        return $this->APIToken;
    }

    public function withAPIToken(string $APIToken): self
    {
        $new = clone $this;
        $new->APIToken = $APIToken;

        return $new;
    }

    /**
     * @return string
     */
    public function getQRCodeImage()
    {
        return $this->QRCodeImage;
    }

    public function withQRCodeImage(string $QRCodeImage): self
    {
        $new = clone $this;
        $new->QRCodeImage = $QRCodeImage;

        return $new;
    }
}
