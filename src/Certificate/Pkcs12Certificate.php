<?php

declare(strict_types=1);

namespace Twint\Sdk\Certificate;

use Override;
use Psr\Clock\ClockInterface;
use Twint\Sdk\Exception\InvalidCertificate;
use Twint\Sdk\Io\FileStream;
use Twint\Sdk\Io\FileWriter;
use Twint\Sdk\Io\LazyStream;
use Twint\Sdk\Io\ProcessingStream;
use Twint\Sdk\Io\Stream;
use function Psl\invariant;
use function Psl\Type\non_empty_string;
use function Psl\Type\non_empty_vec;

final class Pkcs12Certificate implements Certificate
{
    /**
     * @param Stream<non-empty-string> $content
     * @param non-empty-string $passphrase
     */
    public function __construct(
        private readonly Stream $content,
        private readonly string $passphrase,
        private ?PemCertificate $parent = null
    ) {
    }

    /**
     * @param Stream<non-empty-string> $content
     * @param non-empty-string $passphrase
     * @throws InvalidCertificate
     */
    public static function establishTrust(Stream $content, string $passphrase, ClockInterface $clock): self
    {
        return self::establishTrustVia($content, $passphrase, new DefaultTrustor($clock));
    }

    /**
     * @param Stream<non-empty-string> $content
     * @param non-empty-string $passphrase
     * @throws InvalidCertificate
     */
    public static function establishTrustVia(Stream $content, string $passphrase, Trustor $trustor): self
    {
        self::flushOpenSslErrors();
        if (!openssl_pkcs12_read($content->read(), $certs, $passphrase)) {
            throw InvalidCertificate::notTrusted(
                self::mapOpenSslErrors(non_empty_vec(non_empty_string())->assert(self::flushOpenSslErrors()))
            );
        }

        $trustor->check($certs['cert']);

        return new self($content, $passphrase);
    }

    /**
     * @return list<string>
     */
    private static function flushOpenSslErrors(): array
    {
        $errors = [];

        while (($error = openssl_error_string()) !== false) {
            $errors[] = $error;
        }

        return $errors;
    }

    /**
     * @param non-empty-list<string> $openSslErrors
     * @return non-empty-list<InvalidCertificate::*>
     */
    private static function mapOpenSslErrors(array $openSslErrors): array
    {
        $errors = [];

        foreach ($openSslErrors as $openSslError) {
            $errors[] = match ($openSslError) {
                'error:11800071:PKCS12 routines::mac verify failure' => InvalidCertificate::ERROR_INVALID_PASSPHRASE,
                default => InvalidCertificate::ERROR_INVALID_CERTIFICATE_FORMAT
            };
        }

        return array_values(array_unique($errors));
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

    public function pem(): PemCertificate
    {
        return $this->parent ??= new PemCertificate(
            new LazyStream(
                new ProcessingStream(
                    $this->content,
                    function (string $content): string {
                        invariant(
                            openssl_pkcs12_read($content, $certs, $this->passphrase()),
                            'Reading PKCS12 file failed'
                        );
                        invariant(openssl_x509_export($certs['cert'], $pemCert), 'X509 certificate export failed');
                        invariant(
                            openssl_pkey_export($certs['pkey'], $pemKey, $this->passphrase()),
                            'Private key export failed'
                        );

                        return non_empty_string()->assert($pemCert . $pemKey);
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
        return new FileStream($writer->write($this->content->read(), '.p12'));
    }
}
