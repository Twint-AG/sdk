<?php

declare(strict_types=1);

namespace Twint\Sdk\Certificate;

use Deprecated;
use Override;
use Psr\Clock\ClockInterface;
use SensitiveParameter;
use Twint\Sdk\Certificate\TlsBackend\CertificateConverter;
use Twint\Sdk\Certificate\TlsBackend\CertificateReader;
use Twint\Sdk\Exception\InvalidCertificate;
use Twint\Sdk\Exception\OpenSslError;
use Twint\Sdk\Factory\DefaultCertificateReaderFactory;
use Twint\Sdk\Io\FileStream;
use Twint\Sdk\Io\FileWriter;
use Twint\Sdk\Io\Stream;
use function Psl\Type\non_empty_string;
use function Psl\Type\non_empty_vec;
use function Psl\Type\shape;
use function Psl\Type\string;

final class Pkcs12Certificate extends ConvertibleCertificate implements ToPkcs8, ToPkcs1
{
    private Pkcs1Certificate $pkcs1;

    private Pkcs8Certificate $pkcs8;

    /**
     * @param Stream<non-empty-string> $content
     * @param non-empty-string $passphrase
     * @param callable(): CertificateReader $certificateReaderFactory
     * @throws InvalidCertificate
     */
    public static function establishTrust(
        Stream $content,
        #[SensitiveParameter]
        string $passphrase,
        ClockInterface $clock,
        mixed $certificateReaderFactory = new DefaultCertificateReaderFactory()
    ): self {
        return self::establishTrustVia($content, $passphrase, new DefaultTrustor($clock), $certificateReaderFactory);
    }

    /**
     * @param Stream<non-empty-string> $content
     * @param non-empty-string $passphrase
     * @param callable(): CertificateReader $certificateReaderFactory
     * @throws InvalidCertificate
     */
    public static function establishTrustVia(
        Stream $content,
        #[SensitiveParameter]
        string $passphrase,
        Trustor $trustor,
        mixed $certificateReaderFactory = new DefaultCertificateReaderFactory()
    ): self {
        OpenSslError::flushOpenSslErrors();

        if (!openssl_pkcs12_read($content->read(), $certs, $passphrase)) {
            throw InvalidCertificate::notTrusted(
                self::mapOpenSslErrors(non_empty_vec(non_empty_string())->assert(OpenSslError::flushOpenSslErrors())),
                OpenSslError::fromOpenSslErrors()
            );
        }

        shape([
            'cert' => string(),
        ], true)->assert($certs);

        $trustor->check($certs['cert']);

        return new self($content, $passphrase, $certificateReaderFactory);
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
    public function pkcs1(): Pkcs1Certificate
    {
        return $this->pkcs1 ??= $this->to(
            CertificateConverter::PKCS12,
            Pkcs1Certificate::class,
            CertificateConverter::PKCS1
        );
    }

    #[Override]
    public function pkcs8(): Pkcs8Certificate
    {
        return $this->pkcs8 ??= $this->to(
            CertificateConverter::PKCS12,
            Pkcs8Certificate::class,
            CertificateConverter::PKCS8
        );
    }

    #[Deprecated]
    public function pem(): PemCertificate
    {
        @trigger_error(
            'This method is deprecated and will be removed in the next major version. Use \Twint\Sdk\Certificate\Pkcs12Certificate::pkcs8e instead.',
            E_USER_DEPRECATED
        );

        return $this->pkcs8();
    }

    #[Override]
    public function toFile(FileWriter $writer): FileStream
    {
        return new FileStream($writer->write($this->content(), '.p12'));
    }
}
