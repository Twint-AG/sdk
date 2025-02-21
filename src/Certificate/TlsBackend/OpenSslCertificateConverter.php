<?php

declare(strict_types=1);

namespace Twint\Sdk\Certificate\TlsBackend;

use OpenSSLAsymmetricKey;
use OpenSSLCertificate;
use Override;
use phpseclib3\Crypt\Common\PrivateKey;
use phpseclib3\Crypt\RSA;
use SensitiveParameter;
use Twint\Sdk\Exception\CryptographyFailure;
use Twint\Sdk\Exception\OpenSslError;
use function Psl\Type\instance_of;
use function Psl\Type\non_empty_string;

final class OpenSslCertificateConverter implements CertificateConverter
{
    public function __construct(
        #[SensitiveParameter]
        private readonly OpenSSLCertificate $certificate,
        #[SensitiveParameter]
        private readonly OpenSSLAsymmetricKey $privateKey,
        #[SensitiveParameter]
        private readonly string $passphrase
    ) {
    }

    /**
     * @throws CryptographyFailure
     */
    #[Override]
    public function to(string $format): string
    {
        return match ($format) {
            self::PKCS1 => $this->toPkcs1(),
            self::PKCS8 => $this->toPkcs8(),
            self::PKCS12 => $this->toPkcs12(),
        };
    }

    /**
     * @throws CryptographyFailure
     * @return non-empty-string
     */
    private function toPkcs1(): string
    {
        return $this->exportX509() . $this->exportDesKey();
    }

    /**
     * @throws CryptographyFailure
     * @return non-empty-string
     */
    private function exportDesKey(): string
    {
        $privateKey = instance_of(PrivateKey::class)
            ->assert(RSA::load($this->exportPrivateKey(), $this->passphrase));

        return non_empty_string()
            ->assert(
                $privateKey->toString(
                    'PKCS1',
                    [
                        'encrypt' => true,
                        'encryptionAlgorithm' => 'DES-EDE3-CBC',
                        'password' => $this->passphrase,
                    ]
                )
            );
    }

    /**
     * @throws CryptographyFailure
     * @return non-empty-string
     */
    private function toPkcs8(): string
    {
        return $this->exportX509() . $this->exportPrivateKey();
    }

    /**
     * @throws CryptographyFailure
     * @return non-empty-string
     */
    private function toPkcs12(): string
    {
        if (!openssl_pkcs12_export($this->certificate, $p12Cert, $this->privateKey, $this->passphrase)) {
            throw new CryptographyFailure('PKCS12 export failed', 0, OpenSslError::fromOpenSslErrors());
        }

        return non_empty_string()->assert($p12Cert);
    }

    /**
     * @throws CryptographyFailure
     * @return non-empty-string
     */
    private function exportX509(): string
    {
        if (!openssl_x509_export($this->certificate, $exported)) {
            throw new CryptographyFailure('X509 certificate export failed', 0, OpenSslError::fromOpenSslErrors());
        }

        return non_empty_string()->assert($exported);
    }

    /**
     * @throws CryptographyFailure
     * @return non-empty-string
     */
    private function exportPrivateKey(): string
    {
        if (!openssl_pkey_export(
            $this->privateKey,
            $exported,
            $this->passphrase,
            [
                // Specify empty OpenSSL configuration file
                //
                // An empty OpenSSL configuration file makes sure that no system CA is used here
                // This is important because the system CA file might not be available or misconfigured
                // and would lead to an error. Because a CA file is not strictly needed for this
                // operation, we make sure it's not considered.
                'config' => __DIR__ . '/../../../resources/config/openssl.cnf',
            ]
        )) {
            throw new CryptographyFailure('Private key export failed', 0, OpenSslError::fromOpenSslErrors());
        }

        return non_empty_string()->assert($exported);
    }
}
