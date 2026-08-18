<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use Phpro\SoapClient\Type\ResultInterface;

class GetOrderResponseType implements ResultInterface
{
    protected OrderType $Order;

    protected ?string $ApiToken = null;

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

    public function getApiToken(): ?string
    {
        return $this->ApiToken;
    }

    public function withApiToken(?string $ApiToken): static
    {
        $new = clone $this;
        $new->ApiToken = $ApiToken;

        return $new;
    }
}
