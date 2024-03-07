<?php

declare(strict_types=1);

namespace Twint\Sdk;

use Twint\Sdk\Value\CertificateValidity;
use Twint\Sdk\Value\MerchantId;

interface Client
{
    public function getCertificateValidity(MerchantId $merchantId): CertificateValidity;
}
