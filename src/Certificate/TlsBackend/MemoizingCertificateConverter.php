<?php

declare(strict_types=1);

namespace Twint\Sdk\Certificate\TlsBackend;

use Override;
use Twint\Sdk\Exception\CryptographyFailure;

final class MemoizingCertificateConverter implements CertificateConverter
{
    /**
     * @var array<self::*, non-empty-string>
     */
    private array $store;

    public function __construct(
        private readonly CertificateConverter $inner
    ) {
    }

    /**
     * @throws CryptographyFailure
     */
    #[Override]
    public function to(string $format): string
    {
        return $this->store[$format] ??= $this->inner->to($format);
    }
}
