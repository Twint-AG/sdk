<?php

namespace Twint\Sdk\Generated\Type;

use Phpro\SoapClient\Type\RequestInterface;

class CheckSystemStatusRequestType implements RequestInterface
{
    /**
     * @var \Twint\Sdk\Generated\Type\MerchantInformationType
     */
    private $MerchantInformation;

    /**
     * Constructor
     *
     * @var \Twint\Sdk\Generated\Type\MerchantInformationType $MerchantInformation
     */
    public function __construct($MerchantInformation)
    {
        $this->MerchantInformation = $MerchantInformation;
    }

    /**
     * @return \Twint\Sdk\Generated\Type\MerchantInformationType
     */
    public function getMerchantInformation()
    {
        return $this->MerchantInformation;
    }

    /**
     * @param \Twint\Sdk\Generated\Type\MerchantInformationType $MerchantInformation
     * @return CheckSystemStatusRequestType
     */
    public function withMerchantInformation($MerchantInformation)
    {
        $new = clone $this;
        $new->MerchantInformation = $MerchantInformation;

        return $new;
    }
}

