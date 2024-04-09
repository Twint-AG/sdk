<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Integration;

use PHPUnit\Event\Code\TestMethodBuilder;
use PHPUnit\Framework\TestCase;
use Twint\Sdk\ApiClient;
use Twint\Sdk\Certificate;
use Twint\Sdk\Client;
use Twint\Sdk\Factory\DefaultSoapEngineFactory;
use Twint\Sdk\File\ContentSensitiveFileWriter;
use Twint\Sdk\Tools\PHPUnit\VcrUtil;
use Twint\Sdk\TwintEnvironment;
use Twint\Sdk\TwintVersion;
use Twint\Sdk\Value\File;
use Twint\Sdk\Value\MerchantId;
use Twint\Sdk\Value\UnfiledMerchantTransactionReference;
use Twint\Sdk\Value\Uuid;
use function Psl\Type\non_empty_string;

abstract class IntegrationTest extends TestCase
{
    protected const SOAP_REQUEST_MATCHERS = ['method', 'url', 'host', 'body', 'soap_operation'];

    protected Client $client;

    /**
     * @var array<string, int>
     */
    private static array $merchantTransactionReferenceVersions = [];

    /**
     * @return non-empty-string
     */
    protected static function getEnvironmentVariable(string $name): string
    {
        return non_empty_string()->assert($_SERVER[$name] ?? '');
    }

    protected static function getMerchantId(): MerchantId
    {
        return MerchantId::fromString(self::getEnvironmentVariable('TWINT_SDK_TEST_MERCHANT_ID'));
    }

    protected function createTransactionReference(): UnfiledMerchantTransactionReference
    {
        $testMethod = TestMethodBuilder::fromTestCase($this);

        $testId = $testMethod->id();
        $suffix = self::$merchantTransactionReferenceVersions[$testId] ?? '';
        self::$merchantTransactionReferenceVersions[$testId] = (self::$merchantTransactionReferenceVersions[$testId] ?? -1) + 1;

        return new UnfiledMerchantTransactionReference(substr(
            hash('sha3-256', sprintf('%d-%s%s', VcrUtil::getFixtureRevision($testMethod), $testId, $suffix)),
            0,
            50
        ));
    }

    protected function setUp(): void
    {
        $this->client = new ApiClient(
            Certificate\CertificateContainer::fromPkcs12(
                new Certificate\Pkcs12Certificate(
                    new Certificate\FileStream(new File(self::getEnvironmentVariable('TWINT_SDK_TEST_CERT_P12_PATH'))),
                    self::getEnvironmentVariable('TWINT_SDK_TEST_CERT_P12_PASSPHRASE')
                )
            ),
            self::getMerchantId(),
            TwintVersion::latest(),
            TwintEnvironment::TESTING(),
            new ContentSensitiveFileWriter(
                new File(__DIR__ . '/../../build/'),
                static function (string $content) {
                    $fingerprint = openssl_x509_fingerprint($content);

                    return $fingerprint !== false ? $fingerprint : hash('sha3-384', $content);
                }
            ),
            new DefaultSoapEngineFactory(static fn () => new Uuid('00000000-0000-0000-0000-000000000000'))
        );
    }
}
