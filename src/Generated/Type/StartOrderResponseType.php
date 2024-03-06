<?php

namespace Twint\Sdk\Generated\Type;

use Phpro\SoapClient\Type\ResultInterface;

class StartOrderResponseType implements ResultInterface
{
    /**
     * @var string
     */
    private $OrderUuid;

    /**
     * @var \Twint\Sdk\Generated\Type\OrderStatusType
     */
    private $OrderStatus;

    /**
     * @var int
     */
    private $Token;

    /**
     * @var string
     */
    private $QRCode;

    /**
     * @var string
     */
    private $TwintURL;

    /**
     * @var \Twint\Sdk\Generated\Type\CustomerInformationType
     */
    private $CustomerInformation;

    /**
     * @var string
     */
    private $PairingStatus;

    /**
     * @return string
     */
    public function getOrderUuid()
    {
        return $this->OrderUuid;
    }

    /**
     * @param string $OrderUuid
     * @return StartOrderResponseType
     */
    public function withOrderUuid($OrderUuid)
    {
        $new = clone $this;
        $new->OrderUuid = $OrderUuid;

        return $new;
    }

    /**
     * @return \Twint\Sdk\Generated\Type\OrderStatusType
     */
    public function getOrderStatus()
    {
        return $this->OrderStatus;
    }

    /**
     * @param \Twint\Sdk\Generated\Type\OrderStatusType $OrderStatus
     * @return StartOrderResponseType
     */
    public function withOrderStatus($OrderStatus)
    {
        $new = clone $this;
        $new->OrderStatus = $OrderStatus;

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
     * @return StartOrderResponseType
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
     * @return StartOrderResponseType
     */
    public function withQRCode($QRCode)
    {
        $new = clone $this;
        $new->QRCode = $QRCode;

        return $new;
    }

    /**
     * @return string
     */
    public function getTwintURL()
    {
        return $this->TwintURL;
    }

    /**
     * @param string $TwintURL
     * @return StartOrderResponseType
     */
    public function withTwintURL($TwintURL)
    {
        $new = clone $this;
        $new->TwintURL = $TwintURL;

        return $new;
    }

    /**
     * @return \Twint\Sdk\Generated\Type\CustomerInformationType
     */
    public function getCustomerInformation()
    {
        return $this->CustomerInformation;
    }

    /**
     * @param \Twint\Sdk\Generated\Type\CustomerInformationType $CustomerInformation
     * @return StartOrderResponseType
     */
    public function withCustomerInformation($CustomerInformation)
    {
        $new = clone $this;
        $new->CustomerInformation = $CustomerInformation;

        return $new;
    }

    /**
     * @return string
     */
    public function getPairingStatus()
    {
        return $this->PairingStatus;
    }

    /**
     * @param string $PairingStatus
     * @return StartOrderResponseType
     */
    public function withPairingStatus($PairingStatus)
    {
        $new = clone $this;
        $new->PairingStatus = $PairingStatus;

        return $new;
    }
}

