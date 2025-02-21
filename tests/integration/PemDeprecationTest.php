<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Integration;

use PHPUnit\Framework\Attributes\CoversClass;
use Twint\Sdk\Certificate\CertificateContainer;
use Twint\Sdk\Certificate\PemCertificate;
use Twint\Sdk\Certificate\Pkcs12Certificate;
use Twint\Sdk\Certificate\Pkcs1Certificate;

/**
 * @internal
 */
#[CoversClass(CertificateContainer::class)]
#[CoversClass(PemCertificate::class)]
#[CoversClass(Pkcs12Certificate::class)]
#[CoversClass(Pkcs1Certificate::class)]
final class PemDeprecationTest extends CertificateIntegrationTest
{
    public function testCreateFromPem(): void
    {
        $pkcs8 = self::getPkcs8();

        self::assertInstanceOf(CertificateContainer::class, CertificateContainer::fromPem($pkcs8));
    }

    public function testContainerAsPem(): void
    {
        $pkcs12 = self::getPkcs12();
        $container = CertificateContainer::fromPkcs12($pkcs12);

        self::assertInstanceOf(PemCertificate::class, $container->pem());
    }

    public function testDeprecatedClassAliasExists(): void
    {
        self::assertTrue(class_exists(PemCertificate::class));
    }

    public function testPkcs12HasDeprecatedPemMethod(): void
    {
        $pkcs12 = self::getPkcs12();

        self::assertInstanceOf(PemCertificate::class, $pkcs12->pem());
    }

    public function testPkcs1HasDeprecatedPemMethod(): void
    {
        $pkcs12 = self::getPkcs1();

        self::assertInstanceOf(PemCertificate::class, $pkcs12->pem());
    }
}
