<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use Phpro\SoapClient\Type\ResultInterface;

final class ConfirmOrderResponseType implements ResultInterface
{
    /**
     * @var MerchantInformationType
     */
    private $MerchantInformation;

    /**
     * @var OrderType
     */
    private $Order;

    /**
     * @return MerchantInformationType
     */
    public function getMerchantInformation()
    {
        return $this->MerchantInformation;
    }

    public function withMerchantInformation(MerchantInformationType $MerchantInformation): self
    {
        $new = clone $this;
        $new->MerchantInformation = $MerchantInformation;

        return $new;
    }

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
