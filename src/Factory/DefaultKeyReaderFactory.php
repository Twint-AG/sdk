<?php

declare(strict_types=1);

namespace Twint\Sdk\Factory;

use Twint\Sdk\Certificate\TlsBackend\CertificateReader;
use Twint\Sdk\Certificate\TlsBackend\MemoizingCertificateReader;
use Twint\Sdk\Certificate\TlsBackend\OpenSslCertificateReader;

final class DefaultKeyReaderFactory
{
    public function __invoke(): CertificateReader
    {
        return new MemoizingCertificateReader(new OpenSslCertificateReader());
    }
}
