<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use DateTimeImmutable;
use Twint\Sdk\Certificate\CertificateContainer;

final class CertificateRenewal
{
    public function __construct(
        private readonly CertificateContainer $certificate,
        private readonly DateTimeImmutable $expiresAt
    ) {
    }

    public function certificate(): CertificateContainer
    {
        return $this->certificate;
    }

    public function expiresAt(): DateTimeImmutable
    {
        return $this->expiresAt;
    }
}
