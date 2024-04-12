<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Integration;

use PHPUnit\Event\Code\TestMethodBuilder;
use PHPUnit\Framework\TestCase;
use Psl\Type\Exception\AssertException;
use Soap\Engine\Encoder;
use Soap\Engine\HttpBinding\SoapRequest;
use Twint\Sdk\ApiClient;
use Twint\Sdk\Certificate;
use Twint\Sdk\Client;
use Twint\Sdk\Factory\DefaultHttpClientFactory;
use Twint\Sdk\Factory\DefaultSoapEngineFactory;
use Twint\Sdk\File\ContentSensitiveFileWriter;
use Twint\Sdk\Soap\RequestModifyingEncoder;
use Twint\Sdk\Tools\Environment;
use Twint\Sdk\Tools\PHPUnit\VcrUtil;
use Twint\Sdk\Tools\WireMock\DefaultWireMockFactory;
use Twint\Sdk\TwintEnvironment;
use Twint\Sdk\TwintVersion;
use Twint\Sdk\Value\File;
use Twint\Sdk\Value\MerchantId;
use Twint\Sdk\Value\UnfiledMerchantTransactionReference;
use Twint\Sdk\Value\Uuid;
use WireMock\Client\WireMock;

abstract class IntegrationTest extends TestCase
{
    final protected const SOAP_REQUEST_MATCHERS = ['method', 'url', 'host', 'body', 'soap_operation'];

    protected Client $client;

    private ?WireMock $wireMock = null;

    /**
     * @var list<non-empty-string>
     */
    private array $wireMockMethods = [];

    /**
     * @var array<string, int>
     */
    private static array $merchantTransactionReferenceVersions = [];

    final protected static function getMerchantId(): MerchantId
    {
        return MerchantId::fromString(Environment::get('TWINT_SDK_TEST_MERCHANT_ID'));
    }

    final protected function createTransactionReference(): UnfiledMerchantTransactionReference
    {
        $testMethod = TestMethodBuilder::fromTestCase($this);

        $testId = $testMethod->id();
        $suffix = self::$merchantTransactionReferenceVersions[$testId] ?? '';
        self::$merchantTransactionReferenceVersions[$testId] = (self::$merchantTransactionReferenceVersions[$testId] ?? -1) + 1;

        try {
            return new UnfiledMerchantTransactionReference(substr(
                hash('sha3-256', sprintf('%d-%s%s', VcrUtil::getFixtureRevision($testMethod), $testId, $suffix)),
                0,
                50
            ));
        } catch (AssertException $e) {
            return new UnfiledMerchantTransactionReference(substr(hash('sha3-256', random_bytes(32)), 0, 50));
        }
    }

    final protected function setUp(): void
    {
        $this->client = new ApiClient(
            Certificate\CertificateContainer::fromPkcs12(
                new Certificate\Pkcs12Certificate(
                    new Certificate\FileStream(new File(Environment::get('TWINT_SDK_TEST_CERT_P12_PATH'))),
                    Environment::get('TWINT_SDK_TEST_CERT_P12_PASSPHRASE')
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
            new DefaultSoapEngineFactory(
                static fn () => new Uuid('00000000-0000-0000-0000-000000000000'),
                new DefaultHttpClientFactory(),
                fn (Encoder $encoder) => new RequestModifyingEncoder(
                    $encoder,
                    fn (SoapRequest $request, string $method) =>
                    new SoapRequest(
                        $request->getRequest(),
                        in_array($method, $this->wireMockMethods, true)
                            ? rtrim(Environment::get('TWINT_SDK_TEST_WIREMOCK_BASE_URL'), '/')
                            . parse_url($request->getLocation(), PHP_URL_PATH)
                            : $request->getLocation(),
                        $request->getAction(),
                        $request->getVersion(),
                        $request->getOneWay()
                    )
                )
            )
        );
    }

    /**
     * @param non-empty-string ...$methods
     */
    final protected function enableWireMockForSoapMethod(string ...$methods): void
    {
        $this->wireMockMethods = array_unique(array_values([...$this->wireMockMethods, ...$methods]));
    }

    final protected function wireMock(): WireMock
    {
        return $this->wireMock ??= $this->createWireMock();
    }

    protected function createWireMock(): WireMock
    {
        return (new DefaultWireMockFactory())();
    }
}
