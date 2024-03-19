<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use AllowDynamicProperties;

#[AllowDynamicProperties]
final class OrderLinkType
{
    /**
     * @var string
     */
    private $MerchantTransactionReference;

    /**
     * @var string
     */
    private $OrderUuid;

    /**
     * @return string
     */
    public function getMerchantTransactionReference()
    {
        return $this->MerchantTransactionReference;
    }

    /**
     * @param string $MerchantTransactionReference
     * @return OrderLinkType
     */
    public function withMerchantTransactionReference($MerchantTransactionReference)
    {
        $new = clone $this;
        $new->MerchantTransactionReference = $MerchantTransactionReference;

        return $new;
    }

    /**
     * @return string
     */
    public function getOrderUuid()
    {
        return $this->OrderUuid;
    }

    /**
     * @param string $OrderUuid
     * @return OrderLinkType
     */
    public function withOrderUuid($OrderUuid)
    {
        $new = clone $this;
        $new->OrderUuid = $OrderUuid;

        return $new;
    }
}
