<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use Phpro\SoapClient\Type\ResultInterface;

class ConfirmOrderResponseType implements ResultInterface
{
    /**
     * Restriction of the Base Merchant Information.
     *  In contrary to that it MUST contain a CashRegister Id. Used as the default type for operations
     *  within the *-POS Cases, where the Actions are performed by specific CashRegisters
     */
    protected MerchantInformationType $MerchantInformation;

    protected OrderType $Order;

    public function getMerchantInformation(): MerchantInformationType
    {
        return $this->MerchantInformation;
    }

    public function withMerchantInformation(MerchantInformationType $MerchantInformation): static
    {
        $new = clone $this;
        $new->MerchantInformation = $MerchantInformation;

        return $new;
    }

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
