<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use Phpro\SoapClient\Type\ResultInterface;

final class FindOrderResponseType implements ResultInterface
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

    public function withOrder(OrderType $Order): self
    {
        $new = clone $this;
        $new->Order = $Order;

        return $new;
    }
}
