<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use Phpro\SoapClient\Type\ResultInterface;

class GetOrderResponseType implements ResultInterface
{
    protected OrderType $Order;

    public function getOrder(): OrderType
    {
        return $this->Order;
    }

    public function withOrder(OrderType $Order): static
    {
        $new = clone $this;
        $new->Order = $Order;

        return $new;
    }
}
