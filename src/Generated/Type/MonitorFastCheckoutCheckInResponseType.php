<?php

namespace Twint\Sdk\Generated\Type;

use Phpro\SoapClient\Type\ResultInterface;

class MonitorFastCheckoutCheckInResponseType implements ResultInterface
{
    /**
     * @var \Twint\Sdk\Generated\Type\CheckInNotificationType
     */
    private $CheckInNotification;

    /**
     * @var string
     */
    private $ShippingMethodId;

    /**
     * @var \Twint\Sdk\Generated\Type\CustomerDataType
     */
    private $CustomerData;

    /**
     * @return \Twint\Sdk\Generated\Type\CheckInNotificationType
     */
    public function getCheckInNotification()
    {
        return $this->CheckInNotification;
    }

    /**
     * @param \Twint\Sdk\Generated\Type\CheckInNotificationType $CheckInNotification
     * @return MonitorFastCheckoutCheckInResponseType
     */
    public function withCheckInNotification($CheckInNotification)
    {
        $new = clone $this;
        $new->CheckInNotification = $CheckInNotification;

        return $new;
    }

    /**
     * @return string
     */
    public function getShippingMethodId()
    {
        return $this->ShippingMethodId;
    }

    /**
     * @param string $ShippingMethodId
     * @return MonitorFastCheckoutCheckInResponseType
     */
    public function withShippingMethodId($ShippingMethodId)
    {
        $new = clone $this;
        $new->ShippingMethodId = $ShippingMethodId;

        return $new;
    }

    /**
     * @return \Twint\Sdk\Generated\Type\CustomerDataType
     */
    public function getCustomerData()
    {
        return $this->CustomerData;
    }

    /**
     * @param \Twint\Sdk\Generated\Type\CustomerDataType $CustomerData
     * @return MonitorFastCheckoutCheckInResponseType
     */
    public function withCustomerData($CustomerData)
    {
        $new = clone $this;
        $new->CustomerData = $CustomerData;

        return $new;
    }
}

