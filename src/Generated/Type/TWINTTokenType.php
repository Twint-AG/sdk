<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use AllowDynamicProperties;

#[AllowDynamicProperties]
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

    /**
     * @param string $DisplayToken
     * @return TWINTTokenType
     */
    public function withDisplayToken($DisplayToken)
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

    /**
     * @param string $APIToken
     * @return TWINTTokenType
     */
    public function withAPIToken($APIToken)
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

    /**
     * @param string $QRCodeImage
     * @return TWINTTokenType
     */
    public function withQRCodeImage($QRCodeImage)
    {
        $new = clone $this;
        $new->QRCodeImage = $QRCodeImage;

        return $new;
    }
}
