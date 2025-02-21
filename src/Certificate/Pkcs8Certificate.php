<?php

declare(strict_types=1);

namespace Twint\Sdk\Certificate;

use Override;
use Twint\Sdk\Certificate\TlsBackend\CertificateConverter;
use Twint\Sdk\Io\FileStream;
use Twint\Sdk\Io\FileWriter;

final class Pkcs8Certificate extends ConvertibleCertificate implements ToPkcs1, ToPkcs12
{
    private Pkcs1Certificate $pkcs1;

    private Pkcs12Certificate $pkcs12;

    #[Override]
    public function pkcs1(): Pkcs1Certificate
    {
        return $this->pkcs1 ??= $this->to(
            CertificateConverter::PKCS8,
            Pkcs1Certificate::class,
            CertificateConverter::PKCS1
        );
    }

    #[Override]
    public function pkcs12(): Pkcs12Certificate
    {
        return $this->pkcs12 ??= $this->to(
            CertificateConverter::PKCS8,
            Pkcs12Certificate::class,
            CertificateConverter::PKCS12
        );
    }

    #[Override]
    public function toFile(FileWriter $writer): FileStream
    {
        return new FileStream($writer->write($this->content(), '.pkcs8.pem'));
    }
}
