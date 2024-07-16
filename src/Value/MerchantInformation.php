<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

interface MerchantInformation
{
    public function merchantId(): MerchantId;

    public function cashRegisterId(): ?CashRegisterId;
}
