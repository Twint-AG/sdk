<?php

declare(strict_types=1);

namespace Twint\Sdk\Certificate;

use Psr\Clock\ClockInterface;
use Twint\Sdk\Exception\InvalidCertificate;
use Twint\Sdk\File\FileWriter;
use function Psl\invariant;

final class Pkcs12Certificate implements Certificate
{
    public function __construct(
        private readonly Stream $content,
        private readonly string $passphrase
    ) {
    }

    /**
     * @throws InvalidCertificate
     */
    public static function establishTrust(Stream $content, string $passphrase, ClockInterface $clock): self
    {
        if (!openssl_pkcs12_read($content->read(), $certs, $passphrase)) {
            throw InvalidCertificate::fromOpensslErrors();
        }

        (new Trustor($certs['cert'], $clock))->check();

        return new self($content, $passphrase);
    }

    public function content(): string
    {
        return $this->content->read();
    }

    public function passphrase(): string
    {
        return $this->passphrase;
    }

    public function pem(): PemCertificate
    {
        return new PemCertificate(
            new ProcessingStream(
                $this->content,
                function (string $content): string {
                    invariant(openssl_pkcs12_read($content, $certs, $this->passphrase()), 'Reading PKCS12 file failed');
                    invariant(openssl_x509_export($certs['cert'], $pemCert), 'X509 certificate export failed');
                    invariant(
                        openssl_pkey_export($certs['pkey'], $pemKey, $this->passphrase()),
                        'Private key export failed'
                    );

                    return $pemCert . $pemKey;
                }
            ),
            $this->passphrase
        );
    }

    public function toFile(FileWriter $writer): FileStream
    {
        return new FileStream($writer->write($this->content->read(), '.p12'));
    }
}
