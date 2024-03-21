<?php

declare(strict_types=1);

namespace Twint\Sdk\Certificate;

use OpenSSLAsymmetricKey;
use OpenSSLCertificate;
use SensitiveParameter;
use Twint\Sdk\Assertion;
use Twint\Sdk\File\FileWriter;

final class PemCertificate implements Certificate
{
    public function __construct(
        private readonly Stream $content,
        #[SensitiveParameter]
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

    public function pkcs12(): Pkcs12Certificate
    {
        return new Pkcs12Certificate(
            new ProcessingStream(
                $this->content,
                function (string $content): string {
                    $privateKey = openssl_get_privatekey($content, $this->passphrase);
                    Assertion::isInstanceOf($privateKey, OpenSSLAsymmetricKey::class, 'Private key extraction failed');

                    $certificate = openssl_x509_read($content);
                    Assertion::isInstanceOf($certificate, OpenSSLCertificate::class, 'Reading X509 certificate failed');

                    Assertion::true(
                        openssl_pkcs12_export($certificate, $p12Cert, $privateKey, $this->passphrase),
                        'PKCS12 export failed'
                    );

                    return $p12Cert;
                }
            ),
            $this->passphrase
        );
    }

    public function toFile(FileWriter $writer): FileStream
    {
        return new FileStream($writer->write($this->content->read(), '.pem'));
    }
}
