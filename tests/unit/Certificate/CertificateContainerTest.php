<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Certificate;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Twint\Sdk\Certificate\CertificateContainer;
use Twint\Sdk\Certificate\PemCertificate;
use Twint\Sdk\Certificate\Pkcs12Certificate;
use Twint\Sdk\Io\InMemoryStream;

/**
 * @internal
 */
#[CoversClass(CertificateContainer::class)]
final class CertificateContainerTest extends TestCase
{
    public function testConvertsToPkcs12WhenCreatedFromPem(): void
    {
        $pem = new PemCertificate(new InMemoryStream('certificate content'), 'password');
        $certificate = CertificateContainer::fromPem($pem);

        self::assertSame($pem, $certificate->pem());
        self::assertNotNull($certificate->pkcs12());
    }

    public function testConvertsToPemWhenCreatedFromPkcs12(): void
    {
        $pkcs12 = new Pkcs12Certificate(new InMemoryStream('certificate content'), 'password');
        $certificate = CertificateContainer::fromPkcs12($pkcs12);

        self::assertSame($pkcs12, $certificate->pkcs12());
        self::assertNotNull($certificate->pem());
    }
}
