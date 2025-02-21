<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Integration;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Component\Clock\Clock;
use Twint\Sdk\Certificate\Pkcs12Certificate;
use Twint\Sdk\Exception\InvalidCertificate;
use Twint\Sdk\Io\FileStream;
use Twint\Sdk\Io\InMemoryStream;
use Twint\Sdk\Io\NonEmptyStream;
use Twint\Sdk\Io\StaticFileWriter;
use Twint\Sdk\Tools\SystemEnvironment;
use Twint\Sdk\Value\ExistingPath;
use function Psl\Type\non_empty_string;

/**
 * @internal
 */
#[CoversClass(Pkcs12Certificate::class)]
#[CoversClass(InvalidCertificate::class)]
final class Pkcs12CertificateTest extends CertificateIntegrationTest
{
    private const PASSPHRASE = 'secret123';

    /**
     * @return iterable<string, array{non-empty-string}>
     */
    public static function getInvalidContent(): iterable
    {
        yield 'Single byte' => [str_repeat(chr(0x0), 1)];
        yield 'Garbage' => [str_repeat(chr(0x0), 1024)];
        yield 'Garbage cert' => [
            non_empty_string()
                ->assert(substr(self::fakeCert(self::PASSPHRASE, 'DE', 'ACME')[0], 0, -1)),
        ];
    }

    public function testWriteToFile(): void
    {
        $cert = self::getPkcs12();

        $file = __DIR__ . '/../../build/cert.p12';
        if (file_exists($file)) {
            unlink($file);
        }
        $cert->toFile(new StaticFileWriter(__DIR__ . '/../../build/cert'));
        self::assertFileExists(__DIR__ . '/../../build/cert.p12');
    }

    public function testSuccessfullyEstablishTrust(): void
    {
        $cert = Pkcs12Certificate::establishTrust(
            new NonEmptyStream(
                new FileStream(new ExistingPath(SystemEnvironment::get('TWINT_SDK_TEST_CERT_P12_PATH')))
            ),
            SystemEnvironment::get('TWINT_SDK_TEST_CERT_P12_PASSPHRASE'),
            new Clock()
        );

        self::assertInstanceOf(Pkcs12Certificate::class, $cert);
    }

    public function testInvalidPassword(): void
    {
        try {
            Pkcs12Certificate::establishTrust(
                new NonEmptyStream(
                    new FileStream(new ExistingPath(SystemEnvironment::get('TWINT_SDK_TEST_CERT_P12_PATH')))
                ),
                'invalidPassword',
                new Clock()
            );
            self::fail('Expected exception');
        } catch (InvalidCertificate $e) {
            self::assertSame([InvalidCertificate::ERROR_INVALID_PASSPHRASE], $e->getErrors());
        }
    }

    /**
     * @param non-empty-string $content
     */
    #[DataProvider('getInvalidContent')]
    public function testInvalidFile(string $content): void
    {
        try {
            Pkcs12Certificate::establishTrust(new InMemoryStream($content), self::PASSPHRASE, new Clock());
            self::fail('Expected exception');
        } catch (InvalidCertificate $e) {
            self::assertSame([InvalidCertificate::ERROR_INVALID_CERTIFICATE_FORMAT], $e->getErrors());
        }
    }
}
