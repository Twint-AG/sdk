<?php

declare(strict_types=1);

namespace Twint\Sdk\Certificate\TlsBackend;

interface CertificateReader
{
    /**
     * @param CertificateConverter::* $format
     * @param non-empty-string $certificate
     */
    public function from(string $format, string $certificate, string $passphrase): CertificateConverter;
}
