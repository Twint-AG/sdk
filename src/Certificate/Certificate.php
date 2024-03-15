<?php

declare(strict_types=1);

namespace Twint\Sdk\Certificate;

interface Certificate
{
    public function pem(): CertificateFile;
}
