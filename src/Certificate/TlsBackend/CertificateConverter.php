<?php

declare(strict_types=1);

namespace Twint\Sdk\Certificate\TlsBackend;

interface CertificateConverter
{
    public const PKCS1 = 'pkcs1';

    public const PKCS8 = 'pkcs8';

    public const PKCS12 = 'pkcs12';

    /**
     * @param self::* $format
     * @return non-empty-string
     */
    public function to(string $format): string;
}
