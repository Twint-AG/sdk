<?php

declare(strict_types=1);

namespace Twint\Sdk\Certificate;

use Override;
use SensitiveParameter;
use Twint\Sdk\Certificate\TlsBackend\CertificateConverter;
use Twint\Sdk\Certificate\TlsBackend\CertificateReader;
use Twint\Sdk\Factory\DefaultKeyReaderFactory;
use Twint\Sdk\Io\LazyStream;
use Twint\Sdk\Io\ProcessingStream;
use Twint\Sdk\Io\Stream;

abstract class ConvertibleCertificate implements Certificate
{
    /**
     * @param Stream<non-empty-string> $content
     * @param non-empty-string $passphrase
     * @param callable(): CertificateReader $keychainFactoryFactory
     */
    final public function __construct(
        #[SensitiveParameter]
        private readonly Stream $content,
        #[SensitiveParameter]
        private readonly string $passphrase,
        private readonly mixed $keychainFactoryFactory = new DefaultKeyReaderFactory(),
        private ?CertificateConverter $keychain = null
    ) {
    }

    #[Override]
    final public function content(): string
    {
        return $this->content->read();
    }

    #[Override]
    final public function passphrase(): string
    {
        return $this->passphrase;
    }

    /**
     * @template TCertificate of self
     * @param CertificateConverter::* $inputFormat
     * @param class-string<TCertificate> $class
     * @param CertificateConverter::* $outputFormat
     * @return TCertificate
     */
    final protected function to(string $inputFormat, string $class, string $outputFormat): self
    {
        $this->keychain ??= ($this->keychainFactoryFactory)()
            ->from($inputFormat, $this->content(), $this->passphrase);

        return new $class(
            new LazyStream(
                new ProcessingStream(
                    $this->content,
                    fn (string $content) => $this->keychain->to($outputFormat)
                )
            ),
            $this->passphrase,
            $this->keychainFactoryFactory,
            $this->keychain
        );
    }
}
