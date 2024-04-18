<?php

declare(strict_types=1);

namespace Twint\Sdk\Certificate;

final class CertificateContainer
{
    private readonly PemCertificate $pem;

    private readonly Pkcs12Certificate $pkcs12;

    private function __construct()
    {
    }

    public static function fromPem(PemCertificate $pem): self
    {
        $container = new self();
        $container->pem = $pem;

        return $container;
    }

    public static function fromPkcs12(Pkcs12Certificate $pkcs12): self
    {
        $container = new self();
        $container->pkcs12 = $pkcs12;

        return $container;
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
