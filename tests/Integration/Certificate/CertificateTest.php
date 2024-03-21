<?php

declare(strict_types=1);

namespace Integration\Certificate;

use PHPUnit\Framework\Attributes\CoversClass;
use Twint\Sdk\Certificate\FileStream;
use Twint\Sdk\Certificate\PemCertificate;
use Twint\Sdk\Certificate\Pkcs12Certificate;
use Twint\Sdk\Checks\PHPUnit\IntegrationTest;
use Twint\Sdk\Value\File;

#[CoversClass(Pkcs12Certificate::class)]
#[CoversClass(PemCertificate::class)]
final class CertificateTest extends IntegrationTest
{
    public function testDeterministicPemConversion(): void
    {
        $pkcs12 = new Pkcs12Certificate(
            new FileStream(new File(self::getEnvironmentVariable('TWINT_SDK_TEST_CERT_P12_PATH'))),
            self::getEnvironmentVariable('TWINT_SDK_TEST_CERT_P12_PASSPHRASE'),
        );

        $pem = $pkcs12->pem()
            ->pkcs12()
            ->pem();

        $newPem = $pem->pkcs12()
            ->pem()
            ->pkcs12()
            ->pem();

        $firstBytes = substr($pem->content(), 0, 1024);

        // Private key is password encrypted and therefore non-deterministic, so we only compare the first bytes
        self::assertNotEmpty($firstBytes);
        self::assertStringStartsWith($firstBytes, $newPem->content());
    }
}
