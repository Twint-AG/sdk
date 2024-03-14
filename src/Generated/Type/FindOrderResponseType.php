<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use Phpro\SoapClient\Type\ResultInterface;

class FindOrderResponseType implements ResultInterface
{
    /**
     * @var array<int<0,max>, \Twint\Sdk\Generated\Type\OrderType>
     */
    protected array $Order;

    /**
     * @return array<int<0,max>, \Twint\Sdk\Generated\Type\OrderType>
     */
    public function getOrder(): array
    {
        return $this->Order;
    }

    /**
     * @param array<int<0,max>, \Twint\Sdk\Generated\Type\OrderType> $Order
     */
    public function withOrder(array $Order): static
    {
        $new = clone $this;
        $new->Order = $Order;

        return $new;
    }
}
