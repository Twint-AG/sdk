<?php

declare(strict_types=1);

namespace Twint\Sdk\Certificate;

use Override;
use SensitiveParameter;
use Twint\Sdk\Certificate\TlsBackend\CertificateConverter;
use Twint\Sdk\Certificate\TlsBackend\CertificateReader;
use Twint\Sdk\Factory\DefaultCertificateReaderFactory;
use Twint\Sdk\Io\LazyStream;
use Twint\Sdk\Io\ProcessingStream;
use Twint\Sdk\Io\Stream;

abstract class ConvertibleCertificate implements Certificate
{
    /**
     * @param Stream<non-empty-string> $content
     * @param non-empty-string $passphrase
     * @param callable(): CertificateReader $certificateReaderFactory
     */
    final public function __construct(
        #[SensitiveParameter]
        private readonly Stream $content,
        #[SensitiveParameter]
        private readonly string $passphrase,
        private readonly mixed $certificateReaderFactory = new DefaultCertificateReaderFactory(),
        private ?CertificateConverter &$certificateConverter = null
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
        return new $class(
            new LazyStream(
                new ProcessingStream(
                    $this->content,
                    fn (string $content) => $this
                        ->certificateConverter($inputFormat, $content)
                        ->to($outputFormat)
                )
            ),
            $this->passphrase,
            $this->certificateReaderFactory,
            $this->certificateConverter
        );
    }

    /**
     * @param CertificateConverter::* $inputFormat
     * @param non-empty-string $content
     */
    private function certificateConverter(string $inputFormat, string $content): CertificateConverter
    {
        return $this->certificateConverter ??= ($this->certificateReaderFactory)()
            ->from($inputFormat, $content, $this->passphrase);
    }
}
