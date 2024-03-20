<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

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

    public function withMerchantTransactionReference(string $MerchantTransactionReference): self
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

    public function withOrderUuid(string $OrderUuid): self
    {
        $new = clone $this;
        $new->OrderUuid = $OrderUuid;

        return $new;
    }
}
