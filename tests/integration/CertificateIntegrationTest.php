<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Integration;

use DateTimeImmutable;
use OpenSSLAsymmetricKey;
use OpenSSLCertificate;
use OpenSSLCertificateSigningRequest;
use PHPUnit\Framework\TestCase;
use Twint\Sdk\Tools\SystemEnvironment;
use Twint\Sdk\Value\MerchantId;
use function Psl\invariant;
use function Psl\Type\instance_of;
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
