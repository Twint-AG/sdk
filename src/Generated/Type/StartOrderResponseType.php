<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use Phpro\SoapClient\Type\ResultInterface;

class StartOrderResponseType implements ResultInterface
{
    /**
     * Base type: restriction of xs:string Pattern: [A-Fa-f0-9]{32}|(\{|\()?[A-Fa-f0-9]{8}-([A-Fa-f0-9]{4}-){3}[A-Fa-f0-9]{12}(\}|\))? This type is used by other XML schema attributes or elements that will
     *  hold a universal unique identifier (UUID), commonly known as either a globally unique identifier (GUID) or UUID. The regular expression defined limits the contents of an attribute to either a
     *  single 32-digit hexadecimal string or a 32-digit hex string patterned as [8]-[4]-[4]-[4]-[12] digits.
     */
    protected string $OrderUuid;

    protected OrderStatusType $OrderStatus;

    protected ?int $Token = null;

    protected ?string $QRCode = null;

    protected ?string $TwintURL = null;

    protected CustomerInformationType $CustomerInformation;

    /**
     * @var 'NO_PAIRING' | 'PAIRING_IN_PROGRESS' | 'PAIRING_ACTIVE'
     */
    protected string $PairingStatus;

    public function getOrderUuid(): string
    {
        return $this->OrderUuid;
    }

    public function withOrderUuid(string $OrderUuid): static
    {
        $new = clone $this;
        $new->OrderUuid = $OrderUuid;

        return $new;
    }

    public function getOrderStatus(): OrderStatusType
    {
        return $this->OrderStatus;
    }

    public function withOrderStatus(OrderStatusType $OrderStatus): static
    {
        $new = clone $this;
        $new->OrderStatus = $OrderStatus;

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

    public function getTwintURL(): ?string
    {
        return $this->TwintURL;
    }

    public function withTwintURL(?string $TwintURL): static
    {
        $new = clone $this;
        $new->TwintURL = $TwintURL;

        return $new;
    }

    public function getCustomerInformation(): CustomerInformationType
    {
        return $this->CustomerInformation;
    }

    public function withCustomerInformation(CustomerInformationType $CustomerInformation): static
    {
        $new = clone $this;
        $new->CustomerInformation = $CustomerInformation;

        return $new;
    }

    /**
     * @return 'NO_PAIRING' | 'PAIRING_IN_PROGRESS' | 'PAIRING_ACTIVE'
     */
    public function getPairingStatus(): string
    {
        return $this->PairingStatus;
    }

    /**
     * @param 'NO_PAIRING' | 'PAIRING_IN_PROGRESS' | 'PAIRING_ACTIVE' $PairingStatus
     */
    public function withPairingStatus(string $PairingStatus): static
    {
        $new = clone $this;
        $new->PairingStatus = $PairingStatus;

        return $new;
    }
}
