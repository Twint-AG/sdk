<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use DateTimeImmutable;

final class CertificateValidity
{
    public function __construct(
        private readonly DateTimeImmutable $expiresAt,
        private readonly bool $renewalAllowed
    ) {
    }

    public function expiresAt(): DateTimeImmutable
    {
        return $this->expiresAt;
    }

    public function isRenewalAllowed(): bool
    {
        return $this->renewalAllowed;
    }
}
