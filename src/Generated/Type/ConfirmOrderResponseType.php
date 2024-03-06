<?php

namespace Twint\Sdk\Generated\Type;

use Phpro\SoapClient\Type\ResultInterface;

class ConfirmOrderResponseType implements ResultInterface
{
    /**
     * @var \Twint\Sdk\Generated\Type\MerchantInformationType
     */
    private $MerchantInformation;

    /**
     * @var \Twint\Sdk\Generated\Type\OrderType
     */
    private $Order;

    /**
     * @return \Twint\Sdk\Generated\Type\MerchantInformationType
     */
    public function getMerchantInformation()
    {
        return $this->MerchantInformation;
    }

    /**
     * @param \Twint\Sdk\Generated\Type\MerchantInformationType $MerchantInformation
     * @return ConfirmOrderResponseType
     */
    public function withMerchantInformation($MerchantInformation)
    {
        $new = clone $this;
        $new->MerchantInformation = $MerchantInformation;

        return $new;
    }

    /**
     * @return \Twint\Sdk\Generated\Type\OrderType
     */
    public function getOrder()
    {
        return $this->Order;
    }

    /**
     * @param \Twint\Sdk\Generated\Type\OrderType $Order
     * @return ConfirmOrderResponseType
     */
    public function withOrder($Order)
    {
        $new = clone $this;
        $new->Order = $Order;

        return $new;
    }
}

