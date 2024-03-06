<?php

namespace Twint\Sdk\Generated\Type;

use Phpro\SoapClient\Type\ResultInterface;

class CancelOrderResponseType implements ResultInterface
{
    /**
     * @var \Twint\Sdk\Generated\Type\OrderType
     */
    private $Order;

    /**
     * @return \Twint\Sdk\Generated\Type\OrderType
     */
    public function getOrder()
    {
        return $this->Order;
    }

    /**
     * @param \Twint\Sdk\Generated\Type\OrderType $Order
     * @return CancelOrderResponseType
     */
    public function withOrder($Order)
    {
        $new = clone $this;
        $new->Order = $Order;

        return $new;
    }
}

