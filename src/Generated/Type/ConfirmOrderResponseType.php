<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use AllowDynamicProperties;
use Phpro\SoapClient\Type\ResultInterface;

#[AllowDynamicProperties]
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

    /**
     * @param MerchantInformationType $MerchantInformation
     * @return ConfirmOrderResponseType
     */
    public function withMerchantInformation($MerchantInformation)
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

    /**
     * @param OrderType $Order
     * @return ConfirmOrderResponseType
     */
    public function withOrder($Order)
    {
        $new = clone $this;
        $new->Order = $Order;

        return $new;
    }
}
