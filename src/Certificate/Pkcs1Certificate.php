<?php

declare(strict_types=1);

namespace Twint\Sdk\Certificate;

use Deprecated;
use Override;
use Twint\Sdk\Certificate\TlsBackend\CertificateConverter;
use Twint\Sdk\Io\FileStream;
use Twint\Sdk\Io\FileWriter;

final class Pkcs1Certificate extends ConvertibleCertificate implements ToPkcs12, ToPkcs8
{
    private Pkcs8Certificate $pkcs8;

    private Pkcs12Certificate $pkcs12;

    #[Override]
    public function toFile(FileWriter $writer): FileStream
    {
        return new FileStream($writer->write($this->content(), '.pkcs1.pem'));
    }

    #[Override]
    public function pkcs8(): Pkcs8Certificate
    {
        return $this->pkcs8 ??= $this->to(
            CertificateConverter::PKCS1,
            Pkcs8Certificate::class,
            CertificateConverter::PKCS8
        );
    }

    #[Override]
    public function pkcs12(): Pkcs12Certificate
    {
        return $this->pkcs12 ??= $this->to(
            CertificateConverter::PKCS1,
            Pkcs12Certificate::class,
            CertificateConverter::PKCS12
        );
    }

    #[Deprecated]
    public function pem(): PemCertificate
    {
        @trigger_error(
            'This method is deprecated and will be removed in the next major version. Use \Twint\Sdk\Certificate\Pkcs1Certificate::pkcs8e instead.',
            E_USER_DEPRECATED
        );

        return $this->pkcs8();
    }
}
