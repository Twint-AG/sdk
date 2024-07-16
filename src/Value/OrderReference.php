<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

interface OrderReference
{
    public function asOrderUuidString(): ?string;

    public function asMerchantTransactionReferenceString(): ?string;
}
