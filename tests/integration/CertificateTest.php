<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Integration;

use DateTimeImmutable;
use OpenSSLAsymmetricKey;
use OpenSSLCertificate;
use OpenSSLCertificateSigningRequest;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Psr\Clock\ClockInterface;
use Symfony\Component\Clock\Clock;
use Symfony\Component\Clock\MockClock;
use Twint\Sdk\Certificate\DefaultTrustor;
use Twint\Sdk\Certificate\PemCertificate;
use Twint\Sdk\Certificate\Pkcs12Certificate;
use Twint\Sdk\Exception\InvalidCertificate;
use Twint\Sdk\Io\FileStream;
use Twint\Sdk\Io\InMemoryStream;
use Twint\Sdk\Tools\SystemEnvironment;
use Twint\Sdk\Value\File;
use Twint\Sdk\Value\MerchantId;
use function Psl\invariant;
use function Psl\Type\instance_of;
use function Psl\Type\shape;
use function Psl\Type\uint;

#[CoversClass(Pkcs12Certificate::class)]
#[CoversClass(PemCertificate::class)]
#[CoversClass(DefaultTrustor::class)]
final class CertificateTest extends TestCase
{
    private const PASSPHRASE = 'secret';

    /**
     * @return iterable<string, array{string}>
     */
    public static function getInvalidContent(): iterable
    {
        yield 'Single byte' => [str_repeat(chr(0x0), 1)];
        yield 'Garbage' => [str_repeat(chr(0x0), 1024)];
        yield 'Garbage cert' => [substr(self::fakeCert(self::PASSPHRASE, 'DE', 'ACME')[0], 0, -1)];
    }

    /**
     * @return iterable<string, array{ClockInterface, string, list<string>}>
     */
    public static function getCertificates(): iterable
    {
        yield 'Invalid issuer country and org' => [
            ...self::invalidCertificateFixture('now', ...self::fakeCert(self::PASSPHRASE, 'DE', 'ACME')),
            ['Invalid issuer country code', 'Invalid issuer organization'],
        ];
        yield 'Invalid issuer org' => [
            ...self::invalidCertificateFixture('now', ...self::fakeCert(self::PASSPHRASE, 'CH', 'ACME')),
            ['Invalid issuer organization'],
        ];
        yield 'Invalid issuer country' => [
            ...self::invalidCertificateFixture('now', ...self::fakeCert(self::PASSPHRASE, 'DE', 'TWINT AG')),
            ['Invalid issuer country code'],
        ];
        yield 'Inclusive validity (upper bound)' => [
            ...self::invalidCertificateFixture('+365 days', ...self::fakeCert(self::PASSPHRASE, 'CH', 'TWINT AG')),
            [],
        ];
        yield 'Just expired' => [
            ...self::invalidCertificateFixture(
                '+365 days +1 millisecond',
                ...self::fakeCert(self::PASSPHRASE, 'CH', 'TWINT AG')
            ),
            [InvalidCertificate::ERROR_CERTIFICATE_EXPIRED],
        ];
        yield 'Just not yet valid' => [
            ...self::invalidCertificateFixture('-1 millisecond', ...self::fakeCert(self::PASSPHRASE, 'CH', 'TWINT AG')),
            [InvalidCertificate::ERROR_CERTIFICATE_NOT_YET_VALID],
        ];
        yield 'Inclusive validity (lower bound)' => [
            ...self::invalidCertificateFixture('now', ...self::fakeCert(self::PASSPHRASE, 'CH', 'TWINT AG')),
            [],
        ];
    }

    /**
     * @return array{ClockInterface, string}
     */
    private static function invalidCertificateFixture(
        string $clockAdjustment,
        string $cert,
        DateTimeImmutable $from,
        DateTimeImmutable $to
    ): array {
        return [new MockClock($from->modify($clockAdjustment)), $cert];
    }

    public function testDeterministicPemConversion(): void
    {
        $pkcs12 = new Pkcs12Certificate(
            new FileStream(new File(SystemEnvironment::get('TWINT_SDK_TEST_CERT_P12_PATH'))),
            SystemEnvironment::get('TWINT_SDK_TEST_CERT_P12_PASSPHRASE'),
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

    public function testSuccessfullyEstablishTrust(): void
    {
        $cert = Pkcs12Certificate::establishTrust(
            new FileStream(new File(SystemEnvironment::get('TWINT_SDK_TEST_CERT_P12_PATH'))),
            SystemEnvironment::get('TWINT_SDK_TEST_CERT_P12_PASSPHRASE'),
            new Clock()
        );

        self::assertInstanceOf(Pkcs12Certificate::class, $cert);
    }

    public function testInvalidPassword(): void
    {
        try {
            Pkcs12Certificate::establishTrust(
                new FileStream(new File(SystemEnvironment::get('TWINT_SDK_TEST_CERT_P12_PATH'))),
                'invalidPassword',
                new Clock()
            );
            self::fail('Expected exception');
        } catch (InvalidCertificate $e) {
            self::assertSame([InvalidCertificate::ERROR_INVALID_PASSPHRASE], $e->getErrors());
        }
    }

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

    /**
     * @param list<InvalidCertificate::*> $expectedErrors
     */
    #[DataProvider('getCertificates')]
    public function testEstablishTrustCases(ClockInterface $clock, string $cert, array $expectedErrors): void
    {
        try {
            $cert = Pkcs12Certificate::establishTrust(new InMemoryStream($cert), self::PASSPHRASE, $clock);

            if (count($expectedErrors) > 0) {
                self::fail('Expected exception');
            }

            self::assertInstanceOf(Pkcs12Certificate::class, $cert);
        } catch (InvalidCertificate $e) {
            self::assertSame($expectedErrors, $e->getErrors());
        }
    }

    /**
     * @return array{string, DateTimeImmutable, DateTimeImmutable}
     */
    private static function fakeCert(string $passphrase, string $country, string $org): array
    {
        $config = [
            'digest_alg' => 'sha256',
            'private_key_bits' => 2048,
            'private_key_type' => OPENSSL_KEYTYPE_RSA,
            'encrypt_key' => true,
        ];
        $privateKey = instance_of(OpenSSLAsymmetricKey::class)
            ->assert(openssl_pkey_new($config));

        $dn = [
            'C' => $country,
            'O' => $org,
            'OU' => 'MerchantCustomers',
            'CN' => 'TWINT-TechUser NFQ Integration Test',
            'UID' => MerchantId::fromString(SystemEnvironment::get('TWINT_SDK_TEST_MERCHANT_ID')),
        ];

        $csr = instance_of(OpenSSLCertificateSigningRequest::class)
            ->assert(openssl_csr_new($dn, $privateKey, $config));
        $cert = instance_of(OpenSSLCertificate::class)
            ->assert(openssl_csr_sign($csr, null, $privateKey, 365, $config));

        invariant(openssl_pkcs12_export($cert, $p12, $privateKey, $passphrase), 'Exporting PKCS12 file failed');

        $metadata = shape([
            'validFrom_time_t' => uint(),
            'validTo_time_t' => uint(),
        ], true)
            ->assert(openssl_x509_parse($cert));

        return [
            $p12,
            new DateTimeImmutable('@' . $metadata['validFrom_time_t']),
            new DateTimeImmutable('@' . $metadata['validTo_time_t']),
        ];
    }
}
