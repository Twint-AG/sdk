<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Certificate;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Twint\Sdk\Certificate\CertificateContainer;
use Twint\Sdk\Certificate\Pkcs12Certificate;
use Twint\Sdk\Certificate\Pkcs1Certificate;
use Twint\Sdk\Certificate\Pkcs8Certificate;
use Twint\Sdk\Certificate\TlsBackend\CertificateReader;
use Twint\Sdk\Io\InMemoryStream;

/**
 * @internal
 */
#[CoversClass(CertificateContainer::class)]
final class CertificateContainerTest extends TestCase
{
    public function testConvertsToPemWhenCreatedFromPkcs1(): void
    {
        $pkcs1 = new Pkcs1Certificate(
            new InMemoryStream('certificate content'),
            'password',
            fn () => $this->createMock(CertificateReader::class)
        );
        $certificateContainer = CertificateContainer::fromPkcs1($pkcs1);

        self::assertSame($pkcs1, $certificateContainer->pkcs1());
        self::assertInstanceOf(Pkcs8Certificate::class, $certificateContainer->pkcs8());
        self::assertInstanceOf(Pkcs12Certificate::class, $certificateContainer->pkcs12());
    }

    public function testConvertsToPkcs12WhenCreatedFromPkcs8(): void
    {
        $pkcs8 = new Pkcs8Certificate(
            new InMemoryStream('certificate content'),
            'password',
            fn () => $this->createMock(CertificateReader::class)
        );
        $certificateContainer = CertificateContainer::fromPkcs8($pkcs8);

        self::assertSame($pkcs8, $certificateContainer->pkcs8());
        self::assertInstanceOf(Pkcs1Certificate::class, $certificateContainer->pkcs1());
        self::assertInstanceOf(Pkcs12Certificate::class, $certificateContainer->pkcs12());
    }

    public function testConvertsToPemWhenCreatedFromPkcs12(): void
    {
        $pkcs12 = new Pkcs12Certificate(
            new InMemoryStream('certificate content'),
            'password',
            fn () => $this->createMock(CertificateReader::class)
        );
        $certificateContainer = CertificateContainer::fromPkcs12($pkcs12);

        self::assertSame($pkcs12, $certificateContainer->pkcs12());
        self::assertInstanceOf(Pkcs1Certificate::class, $certificateContainer->pkcs1());
        self::assertInstanceOf(Pkcs8Certificate::class, $certificateContainer->pkcs8());
    }
}
