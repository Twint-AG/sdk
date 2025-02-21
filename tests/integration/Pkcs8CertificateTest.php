<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Integration;

use PHPUnit\Framework\Attributes\CoversClass;
use Twint\Sdk\Certificate\Pkcs8Certificate;
use Twint\Sdk\Exception\InvalidCertificate;
use Twint\Sdk\Io\StaticFileWriter;

/**
 * @internal
 */
#[CoversClass(Pkcs8Certificate::class)]
#[CoversClass(InvalidCertificate::class)]
final class Pkcs8CertificateTest extends CertificateIntegrationTest
{
    public function testWriteToFile(): void
    {
        $cert = self::getPkcs12();

        $file = __DIR__ . '/../../build/cert.pkcs8.pem';
        if (file_exists($file)) {
            unlink($file);
        }
        $cert->pkcs8()
            ->toFile(new StaticFileWriter(__DIR__ . '/../../build/cert'));

        self::assertFileExists(__DIR__ . '/../../build/cert.pkcs8.pem');
    }
}
