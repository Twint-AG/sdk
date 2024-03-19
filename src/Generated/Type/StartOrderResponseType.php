<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use AllowDynamicProperties;
use Phpro\SoapClient\Type\ResultInterface;

#[AllowDynamicProperties]
final class StartOrderResponseType implements ResultInterface
{
    /**
     * @var string
     */
    private $OrderUuid;

    /**
     * @var OrderStatusType
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
     * @var CustomerInformationType
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
     * @return OrderStatusType
     */
    public function getOrderStatus()
    {
        return $this->OrderStatus;
    }

    /**
     * @param OrderStatusType $OrderStatus
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
     * @return CustomerInformationType
     */
    public function getCustomerInformation()
    {
        return $this->CustomerInformation;
    }

    /**
     * @param CustomerInformationType $CustomerInformation
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
