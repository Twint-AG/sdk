<?php

declare(strict_types=1);

namespace Twint\Sdk\Certificate;

use OpenSSLAsymmetricKey;
use OpenSSLCertificate;
use Override;
use SensitiveParameter;
use Twint\Sdk\Io\FileStream;
use Twint\Sdk\Io\FileWriter;
use Twint\Sdk\Io\LazyStream;
use Twint\Sdk\Io\ProcessingStream;
use Twint\Sdk\Io\Stream;
use function Psl\invariant;
use function Psl\Type\instance_of;
use function Psl\Type\non_empty_string;

final class PemCertificate implements Certificate
{
    /**
     * @param Stream<non-empty-string> $content
     * @param non-empty-string $passphrase
     */
    public function __construct(
        private readonly Stream $content,
        #[SensitiveParameter]
        private readonly string $passphrase,
        private ?Pkcs12Certificate $parent = null
    ) {
    }

    #[Override]
    public function content(): string
    {
        return $this->content->read();
    }

    #[Override]
    public function passphrase(): string
    {
        return $this->passphrase;
    }

    public function pkcs12(): Pkcs12Certificate
    {
        return $this->parent ??= new Pkcs12Certificate(
            new LazyStream(
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

                        return non_empty_string()->assert($p12Cert);
                    }
                )
            ),
            $this->passphrase,
            $this
        );
    }

    #[Override]
    public function toFile(FileWriter $writer): FileStream
    {
        return new FileStream($writer->write($this->content->read(), '.pem'));
    }
}
