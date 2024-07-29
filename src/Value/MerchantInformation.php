<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

interface MerchantInformation
{
    public function storeUuid(): StoreUuid;

    public function cashRegisterId(): ?CashRegisterId;
}
