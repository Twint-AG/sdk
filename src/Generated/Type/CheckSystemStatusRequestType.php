<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

class CheckSystemStatusRequestType
{
    /**
     * Basic identification of a Merchant. MAY contain a CashRegisterId, if the Merchant wants to provide it.
     *  In the cases the CashRegisterId is given it is used, otherwise the request is regarded as belonging to all
     *  Terminals of the Merchant.
     */
    protected MerchantInformationBaseType $MerchantInformation;

    public function getMerchantInformation(): MerchantInformationBaseType
    {
        return $this->MerchantInformation;
    }

    public function withMerchantInformation(MerchantInformationBaseType $MerchantInformation): static
    {
        $new = clone $this;
        $new->MerchantInformation = $MerchantInformation;

        return $new;
    }
}
