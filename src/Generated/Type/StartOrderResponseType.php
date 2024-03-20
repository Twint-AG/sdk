<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use Phpro\SoapClient\Type\ResultInterface;

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

    public function withOrderUuid(string $OrderUuid): self
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

    public function withOrderStatus(OrderStatusType $OrderStatus): self
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

    /**
     * @return string
     */
    public function getTwintURL()
    {
        return $this->TwintURL;
    }

    public function withTwintURL(string $TwintURL): self
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

    public function withCustomerInformation(CustomerInformationType $CustomerInformation): self
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

    public function withPairingStatus(string $PairingStatus): self
    {
        $new = clone $this;
        $new->PairingStatus = $PairingStatus;

        return $new;
    }
}
