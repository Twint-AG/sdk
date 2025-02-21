<?php

declare(strict_types=1);

namespace Twint\Sdk\Certificate;

use Deprecated;
use Override;

final class CertificateContainer implements ToPkcs1, ToPkcs8, ToPkcs12
{
    private readonly ToPkcs1 $toPkcs1;

    private readonly ToPkcs8 $toPkcs8;

    private readonly ToPkcs12 $toPkcs12;

    private readonly Pkcs8Certificate $pkcs8;

    private readonly Pkcs12Certificate $pkcs12;

    private readonly Pkcs1Certificate $pkcs1;

    private function __construct(Certificate $certificate)
    {
        if ($certificate instanceof ToPkcs1) {
            $this->toPkcs1 = $certificate;
        }
        if ($certificate instanceof ToPkcs8) {
            $this->toPkcs8 = $certificate;
        }
        if ($certificate instanceof ToPkcs12) {
            $this->toPkcs12 = $certificate;
        }
        if ($certificate instanceof Pkcs1Certificate) {
            $this->pkcs1 = $certificate;
        }
        if ($certificate instanceof Pkcs8Certificate) {
            $this->pkcs8 = $certificate;
        }
        if ($certificate instanceof Pkcs12Certificate) {
            $this->pkcs12 = $certificate;
        }
    }

    public static function fromPkcs1(Pkcs1Certificate $pkcs1): self
    {
        return new self($pkcs1);
    }

    public static function fromPkcs8(Pkcs8Certificate $pkcs8): self
    {
        return new self($pkcs8);
    }

    #[Deprecated]
    public static function fromPem(PemCertificate $pem): self
    {
        @trigger_error(
            'This method is deprecated and will be removed in the next major version. Use \Twint\Sdk\Certificate\CertificateContainer::fromPkcs8 instead.',
            E_USER_DEPRECATED
        );

        return self::fromPkcs8($pem);
    }

    public static function fromPkcs12(Pkcs12Certificate $pkcs12): self
    {
        return new self($pkcs12);
    }

    #[Override]
    public function pkcs1(): Pkcs1Certificate
    {
        return $this->pkcs1 ??= $this->toPkcs1->pkcs1();
    }

    #[Override]
    public function pkcs8(): Pkcs8Certificate
    {
        return $this->pkcs8 ??= $this->toPkcs8->pkcs8();
    }

    #[Deprecated]
    public function pem(): PemCertificate
    {
        return $this->pkcs8();
    }

    #[Override]
    public function pkcs12(): Pkcs12Certificate
    {
        return $this->pkcs12 ??= $this->toPkcs12->pkcs12();
    }
}
