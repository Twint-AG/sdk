<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use AllowDynamicProperties;
use Phpro\SoapClient\Type\ResultInterface;

#[AllowDynamicProperties]
final class GetOrderResponseType implements ResultInterface
{
    /**
     * @var OrderType
     */
    private $Order;

    /**
     * @return OrderType
     */
    public function getOrder()
    {
        return $this->Order;
    }

    /**
     * @param OrderType $Order
     * @return GetOrderResponseType
     */
    public function withOrder($Order)
    {
        $new = clone $this;
        $new->Order = $Order;

        return $new;
    }
}
