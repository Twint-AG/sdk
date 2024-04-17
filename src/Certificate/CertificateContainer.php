<?php

declare(strict_types=1);

namespace Twint\Sdk\Certificate;

use function Psl\Type\instance_of;
use function Psl\Type\union;

final class CertificateContainer
{
    private readonly PemCertificate $pem;

    private readonly Pkcs12Certificate $pkcs12;

    private function __construct(Certificate $certificate)
    {
        $certificate = union(instance_of(PemCertificate::class), instance_of(Pkcs12Certificate::class))
            ->assert($certificate);

        if ($certificate instanceof Pkcs12Certificate) {
            $this->pkcs12 = $certificate;
        } else {
            $this->pem = $certificate;
        }
    }

    public static function fromPem(PemCertificate $pem): self
    {
        return new self($pem);
    }

    public static function fromPkcs12(Pkcs12Certificate $pkcs12): self
    {
        return new self($pkcs12);
    }

    public function pem(): PemCertificate
    {
        return $this->pem ??= $this->pkcs12->pem();
    }

    public function pkcs12(): Pkcs12Certificate
    {
        return $this->pkcs12 ??= $this->pem->pkcs12();
    }
}
