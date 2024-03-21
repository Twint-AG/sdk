<?php

declare(strict_types=1);

namespace Twint\Sdk\Certificate;

use Twint\Sdk\Assertion;
use Twint\Sdk\File\FileWriter;

final class Pkcs12Certificate implements Certificate
{
    public function __construct(
        private readonly Stream $content,
        private readonly string $passphrase
    ) {
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
                    Assertion::true(
                        openssl_pkcs12_read($content, $certs, $this->passphrase()),
                        'Reading PKCS12 file failed'
                    );

                    Assertion::true(openssl_x509_export($certs['cert'], $pemCert), 'X509 certificate export failed');
                    Assertion::true(
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
