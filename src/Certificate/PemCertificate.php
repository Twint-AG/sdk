<?php

declare(strict_types=1);

namespace Twint\Sdk\Certificate;

final class PemCertificate implements Certificate
{
    public function __construct(
        private readonly CertificateFile $pem
    ) {
    }

    public function pem(): CertificateFile
    {
        return $this->pem;
    }
}
