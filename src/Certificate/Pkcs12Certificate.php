<?php

declare(strict_types=1);

namespace Twint\Sdk\Certificate;

use Twint\Sdk\Assertion;
use Twint\Sdk\Exception\AssertionFailed;

final class Pkcs12Certificate implements Certificate
{
    private ?CertificateFile $pem = null;

    public function __construct(
        private readonly CertificateFile $pkcs12
    ) {
    }

    /**
     * @throws AssertionFailed
     */
    public static function read(string $path, string $passphrase): self
    {
        return new self(new CertificateFile($path, $passphrase));
    }

    /**
     * @throws AssertionFailed
     */
    public function pem(): CertificateFile
    {
        return $this->pem ??= $this->convertToPem();
    }

    /**
     * @throws AssertionFailed
     */
    private function convertToPem(): CertificateFile
    {
        Assertion::true(
            openssl_pkcs12_read($this->pkcs12->content(), $certs, $this->pkcs12->passphrase()),
            sprintf('Reading PKCS12 file failed. Tried to read "%s"', $this->pkcs12->path())
        );

        $passphrase = 'secret123'; // @todo generate random passphrase
        Assertion::true(openssl_x509_export($certs['cert'], $pemCert), 'X509 export failed');
        Assertion::true(openssl_pkey_export($certs['pkey'], $pemKey, $passphrase), 'PKEY export failed');

        $pemPath = tempnam(sys_get_temp_dir(), 'twint');
        Assertion::string($pemPath, 'Creating temporary file failed');

        touch($pemPath);
        chmod($pemPath, 0600);
        file_put_contents($pemPath, $pemCert . $pemKey);
        chmod($pemPath, 0400);

        return new CertificateFile($pemPath, $passphrase);
    }
}
