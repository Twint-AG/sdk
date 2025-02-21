<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Integration;

use DateTimeImmutable;
use OpenSSLAsymmetricKey;
use OpenSSLCertificate;
use OpenSSLCertificateSigningRequest;
use PHPUnit\Framework\TestCase;
use Twint\Sdk\Certificate\Pkcs12Certificate;
use Twint\Sdk\Certificate\Pkcs1Certificate;
use Twint\Sdk\Certificate\Pkcs8Certificate;
use Twint\Sdk\Io\FileStream;
use Twint\Sdk\Io\InMemoryStream;
use Twint\Sdk\Io\NonEmptyStream;
use Twint\Sdk\Tools\SystemEnvironment;
use Twint\Sdk\Value\ExistingPath;
use Twint\Sdk\Value\StoreUuid;
use function Psl\invariant;
use function Psl\Type\instance_of;
use function Psl\Type\non_empty_string;
use function Psl\Type\shape;
use function Psl\Type\uint;

abstract class CertificateIntegrationTest extends TestCase
{
    /**
     * @return array{non-empty-string, DateTimeImmutable, DateTimeImmutable}
     */
    protected static function fakeCert(string $passphrase, string $country, string $org): array
    {
        $config = [
            'digest_alg' => 'sha256',
            'private_key_bits' => 2048,
            'private_key_type' => OPENSSL_KEYTYPE_RSA,
            'encrypt_key' => true,
        ];

        $dn = [
            'C' => $country,
            'O' => $org,
            'OU' => 'MerchantCustomers',
            'CN' => 'TWINT-TechUser NFQ Integration Test',
            'UID' => StoreUuid::fromString(SystemEnvironment::get('TWINT_SDK_TEST_STORE_UUID')),
        ];

        $csr = instance_of(OpenSSLCertificateSigningRequest::class)
            ->assert(openssl_csr_new($dn, $privateKey, $config));
        $privateKey = instance_of(OpenSSLAsymmetricKey::class)
            ->assert($privateKey);
        $cert = instance_of(OpenSSLCertificate::class)
            ->assert(openssl_csr_sign($csr, null, $privateKey, 365, $config));

        invariant(openssl_pkcs12_export($cert, $p12, $privateKey, $passphrase), 'Exporting PKCS12 file failed');

        $metadata = shape([
            'validFrom_time_t' => uint(),
            'validTo_time_t' => uint(),
        ], true)
            ->assert(openssl_x509_parse($cert));

        return [
            non_empty_string()
                ->assert($p12),
            new DateTimeImmutable('@' . $metadata['validFrom_time_t']),
            new DateTimeImmutable('@' . $metadata['validTo_time_t']),
        ];
    }

    final protected static function getPkcs12(): Pkcs12Certificate
    {
        $pkcs12 = new Pkcs12Certificate(
            new NonEmptyStream(
                new FileStream(new ExistingPath(SystemEnvironment::get('TWINT_SDK_TEST_CERT_P12_PATH')))
            ),
            SystemEnvironment::get('TWINT_SDK_TEST_CERT_P12_PASSPHRASE')
        );

        return new Pkcs12Certificate(
            new InMemoryStream($pkcs12->content()),
            SystemEnvironment::get('TWINT_SDK_TEST_CERT_P12_PASSPHRASE')
        );
    }

    final protected static function getPkcs8(): Pkcs8Certificate
    {
        $pkcs12 = new Pkcs12Certificate(
            new NonEmptyStream(
                new FileStream(new ExistingPath(SystemEnvironment::get('TWINT_SDK_TEST_CERT_P12_PATH')))
            ),
            SystemEnvironment::get('TWINT_SDK_TEST_CERT_P12_PASSPHRASE')
        );

        return new Pkcs8Certificate(
            new InMemoryStream($pkcs12->pkcs8()->content()),
            SystemEnvironment::get('TWINT_SDK_TEST_CERT_P12_PASSPHRASE')
        );
    }

    final protected static function getPkcs1(): Pkcs1Certificate
    {
        $pkcs12 = new Pkcs12Certificate(
            new NonEmptyStream(
                new FileStream(new ExistingPath(SystemEnvironment::get('TWINT_SDK_TEST_CERT_P12_PATH')))
            ),
            SystemEnvironment::get('TWINT_SDK_TEST_CERT_P12_PASSPHRASE')
        );

        return new Pkcs1Certificate(
            new InMemoryStream($pkcs12->pkcs1()->content()),
            SystemEnvironment::get('TWINT_SDK_TEST_CERT_P12_PASSPHRASE')
        );
    }
}
