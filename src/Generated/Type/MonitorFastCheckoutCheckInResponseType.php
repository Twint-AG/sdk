<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use Phpro\SoapClient\Type\ResultInterface;

class MonitorFastCheckoutCheckInResponseType implements ResultInterface
{
    protected CheckInNotificationType $CheckInNotification;

    protected ?string $ShippingMethodId = null;

    protected ?CustomerDataType $CustomerData = null;

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

    public function getShippingMethodId(): ?string
    {
        return $this->ShippingMethodId;
    }

    public function withShippingMethodId(?string $ShippingMethodId): static
    {
        $new = clone $this;
        $new->ShippingMethodId = $ShippingMethodId;

        return $new;
    }

    public function getCustomerData(): ?CustomerDataType
    {
        return $this->CustomerData;
    }

    public function withCustomerData(?CustomerDataType $CustomerData): static
    {
        $new = clone $this;
        $new->CustomerData = $CustomerData;

        return $new;
    }
}
