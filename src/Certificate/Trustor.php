<?php

declare(strict_types=1);

namespace Twint\Sdk\Certificate;

use OpenSSLCertificate;

interface Trustor
{
    public function check(OpenSSLCertificate|string $certificate): void;
}
