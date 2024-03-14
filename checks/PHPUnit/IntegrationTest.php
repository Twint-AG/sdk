<?php

declare(strict_types=1);

namespace Twint\Sdk\Checks\PHPUnit;

use PHPUnit\Event\Code\TestMethodBuilder;
use PHPUnit\Framework\TestCase;
use Twint\Sdk\ApiClient;
use Twint\Sdk\Assertion;
use Twint\Sdk\Certificate;
use Twint\Sdk\Client;
use Twint\Sdk\Factory\DefaultSoapEngineFactory;
use Twint\Sdk\File\ContentSensitiveFileWriter;
use Twint\Sdk\TwintEnvironment;
use Twint\Sdk\TwintVersion;
use Twint\Sdk\Value\File;
use Twint\Sdk\Value\MerchantId;
use Twint\Sdk\Value\TransactionReference;
use Twint\Sdk\Value\Uuid;

abstract class IntegrationTest extends TestCase
{
    protected const SOAP_REQUEST_MATCHERS = ['method', 'url', 'host', 'soap_operation'];

    protected Client $client;

    /**
     * @return non-empty-string
     */
    protected static function getEnvironmentVariable(string $name): string
    {
        $value = $_SERVER[$name] ?? null;

        Assertion::string($value, 'Environment variable ' . $name . ' is not set');
        Assertion::notEmpty($value, 'Environment variable ' . $name . ' is empty');

        return $value;
    }

    protected static function getMerchantId(): MerchantId
    {
        return MerchantId::fromString(self::getEnvironmentVariable('TWINT_SDK_TEST_MERCHANT_ID'));
    }

    protected function createTransactionReference(): TransactionReference
    {
        $testMethod = TestMethodBuilder::fromTestCase($this);

        return new TransactionReference(substr(
            hash('sha3-256', sprintf('%d-%s', VcrUtil::getFixtureRevision($testMethod), $testMethod->id())),
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
            TwintVersion::latest(),
            TwintEnvironment::TESTING(),
            new ContentSensitiveFileWriter(
                new File(__DIR__ . '/../../build/'),
                static fn (string $content) => openssl_x509_fingerprint($content) ?: hash('sha3-384', $content)
            ),
            new DefaultSoapEngineFactory(static fn () => new Uuid('00000000-0000-0000-0000-000000000000'))
        );
    }
}
