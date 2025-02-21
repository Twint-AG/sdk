<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Integration;

use PHPUnit\Framework\Attributes\CoversClass;
use Twint\Sdk\Certificate\Pkcs1Certificate;
use Twint\Sdk\Exception\InvalidCertificate;
use Twint\Sdk\Io\StaticFileWriter;

/**
 * @internal
 */
#[CoversClass(Pkcs1Certificate::class)]
#[CoversClass(InvalidCertificate::class)]
final class Pkcs1CertificateTest extends CertificateIntegrationTest
{
    public function testWriteToFile(): void
    {
        $cert = self::getPkcs12();

        $file = __DIR__ . '/../../build/cert.pkcs1.pem';
        if (file_exists($file)) {
            unlink($file);
        }
        $cert->pkcs1()
            ->toFile(new StaticFileWriter(__DIR__ . '/../../build/cert'));

        self::assertFileExists(__DIR__ . '/../../build/cert.pkcs1.pem');
    }
}
