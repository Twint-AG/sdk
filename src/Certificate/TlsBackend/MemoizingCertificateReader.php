<?php

declare(strict_types=1);

namespace Twint\Sdk\Certificate\TlsBackend;

use Override;
use Twint\Sdk\Certificate\CertificateContainer;

final class MemoizingCertificateReader implements CertificateReader
{
    /**
     * @var array<CertificateContainer::*, array<non-empty-string, array<string, CertificateConverter>>>
     */
    private array $store = [];

    public function __construct(
        private readonly CertificateReader $inner
    ) {
    }

    #[Override]
    public function from(string $format, string $certificate, string $passphrase): CertificateConverter
    {
        return $this->store[$format][$certificate][$passphrase] ??= new MemoizingCertificateConverter(
            $this->inner->from($format, $certificate, $passphrase)
        );
    }
}
