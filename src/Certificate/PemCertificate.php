<?php

declare(strict_types=1);

namespace Twint\Sdk\Certificate;

use OpenSSLAsymmetricKey;
use OpenSSLCertificate;
use SensitiveParameter;
use Twint\Sdk\File\FileWriter;
use function Psl\invariant;
use function Psl\Type\instance_of;

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
                    invariant(
                        openssl_pkcs12_export(
                            instance_of(OpenSSLCertificate::class)
                                ->assert(openssl_x509_read($content)),
                            $p12Cert,
                            instance_of(OpenSSLAsymmetricKey::class)
                                ->assert(openssl_get_privatekey($content, $this->passphrase)),
                            $this->passphrase
                        ),
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
