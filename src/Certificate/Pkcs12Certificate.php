<?php

declare(strict_types=1);

namespace Twint\Sdk\Certificate;

use SensitiveParameter;
use Twint\Sdk\Assertion;
use Twint\Sdk\Exception\AssertionFailed;
use Twint\Sdk\Factory\RandomPassphraseFactory;
use Twint\Sdk\Factory\TemporaryFileFactory;
use Twint\Sdk\Value\File;

final class Pkcs12Certificate implements Certificate
{
    private ?CertificateFile $pem = null;

    /**
     * @param callable(): File $fileFactory
     * @param callable(): non-empty-string $passwordFactory
     */
    public function __construct(
        #[SensitiveParameter]
        private readonly CertificateFile $pkcs12,
        private readonly mixed $fileFactory = new TemporaryFileFactory(),
        private readonly mixed $passwordFactory = new RandomPassphraseFactory()
    ) {
    }

    /**
     * @param callable(): File $fileFactory
     * @param callable(): non-empty-string $passwordFactory
     * @throws AssertionFailed
     */
    public static function read(
        #[SensitiveParameter]
        string $path,
        #[SensitiveParameter]
        string $passphrase,
        mixed $fileFactory = new TemporaryFileFactory(),
        mixed $passwordFactory = new RandomPassphraseFactory()
    ): self {
        return new self(new CertificateFile(new File($path), $passphrase), $fileFactory, $passwordFactory);
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
            sprintf('Reading PKCS12 file failed. Tried to read "%s"', $this->pkcs12->file())
        );

        $passphrase = ($this->passwordFactory)();
        Assertion::true(openssl_x509_export($certs['cert'], $pemCert), 'X509 export failed');
        Assertion::true(openssl_pkey_export($certs['pkey'], $pemKey, $passphrase), 'PKEY export failed');

        $pemPath = ($this->fileFactory)();

        $origUmask = umask(277);
        try {
            file_put_contents((string) $pemPath, $pemCert . $pemKey);
            chmod((string) $pemPath, 0400);
        } finally {
            umask($origUmask);
        }

        return new CertificateFile($pemPath, $passphrase);
    }
}
