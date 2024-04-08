<?php

declare(strict_types=1);

namespace Twint\Sdk\Certificate;

use Twint\Sdk\Exception\CryptographyFailure;

final class CertificateContainer
{
    private PemCertificate $pem;

    private Pkcs12Certificate $pkcs12;

    /**
     * @throws CryptographyFailure
     */
    private function __construct(Certificate $main)
    {
        if ($main instanceof Pkcs12Certificate) {
            $this->pkcs12 = $main;
        } elseif ($main instanceof PemCertificate) {
            $this->pem = $main;
        } else {
            throw new CryptographyFailure(sprintf('Unsupported certificate type "%s"', get_class($main)));
        }
    }

    /**
     * @throws CryptographyFailure
     */
    public static function fromPem(PemCertificate $pem): self
    {
        return new self($pem);
    }

    /**
     * @throws CryptographyFailure
     */
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
