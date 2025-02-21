<?php

declare(strict_types=1);

namespace Twint\Sdk\Certificate\TlsBackend;

use Override;
use Twint\Sdk\Exception\CryptographyFailure;
use Twint\Sdk\Exception\OpenSslError;
use function Psl\Type\shape;
use function Psl\Type\string;

final class OpenSslCertificateReader implements CertificateReader
{
    /**
     * @throws CryptographyFailure
     */
    #[Override]
    public function from(string $format, string $certificate, string $passphrase): CertificateConverter
    {
        return match ($format) {
            CertificateConverter::PKCS1 => $this->fromPkcs1($certificate, $passphrase),
            CertificateConverter::PKCS8 => $this->fromPkcs8($certificate, $passphrase),
            CertificateConverter::PKCS12 => $this->fromPkcs12($certificate, $passphrase),
        };
    }

    /**
     * @throws CryptographyFailure
     */
    private function fromPkcs1(string $certificate, string $passphrase): CertificateConverter
    {
        return $this->fromPkcs8($certificate, $passphrase);
    }

    /**
     * @throws CryptographyFailure
     */
    private function fromPkcs8(string $certificate, string $passphrase): CertificateConverter
    {
        $privateKey = openssl_pkey_get_private($certificate, $passphrase);
        if ($privateKey === false) {
            throw new CryptographyFailure('Reading private key failed', 0, OpenSslError::fromOpenSslErrors());
        }

        $certificate = openssl_x509_read($certificate);
        if ($certificate === false) {
            throw new CryptographyFailure('Reading X509 certificate failed', 0, OpenSslError::fromOpenSslErrors());
        }

        return new OpenSslCertificateConverter($certificate, $privateKey, $passphrase);
    }

    /**
     * @throws CryptographyFailure
     */
    private function fromPkcs12(string $certificate, string $passphrase): CertificateConverter
    {
        if (!openssl_pkcs12_read($certificate, $certs, $passphrase)) {
            throw new CryptographyFailure('Reading PKCS12 file failed', 0, OpenSslError::fromOpenSslErrors());
        }
        shape([
            'cert' => string(),
            'pkey' => string(),
        ], true)->assert($certs);

        return $this->fromPkcs8($certs['cert'] . $certs['pkey'], $passphrase);
    }
}
