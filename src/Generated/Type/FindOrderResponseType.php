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

    /**
     * @param OrderType $Order
     * @return FindOrderResponseType
     */
    public function withOrder($Order)
    {
        $new = clone $this;
        $new->Order = $Order;

        return $new;
    }
}
