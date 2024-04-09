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
use Twint\Sdk\Tools\PHPUnit\VcrUtil;
use Twint\Sdk\TwintEnvironment;
use Twint\Sdk\TwintVersion;
use Twint\Sdk\Value\File;
use Twint\Sdk\Value\MerchantId;
use Twint\Sdk\Value\UnfiledMerchantTransactionReference;
use Twint\Sdk\Value\Uuid;
use WireMock\Client\Authentication\TokenAuthenticator;
use WireMock\Client\Curl;
use WireMock\Client\HttpWait;
use WireMock\Client\WireMock;
use WireMock\Serde\SerializerFactory;
use function Psl\Type\non_empty_string;
use function Psl\Type\optional;
use function Psl\Type\shape;
use function Psl\Type\uint;

abstract class IntegrationTest extends TestCase
{
    protected const SOAP_REQUEST_MATCHERS = ['method', 'url', 'host', 'body', 'soap_operation'];

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
            new DefaultSoapEngineFactory(
                static fn () => new Uuid('00000000-0000-0000-0000-000000000000'),
                new DefaultHttpClientFactory(),
                fn (Encoder $encoder) => new RequestModifyingEncoder(
                    $encoder,
                    fn (SoapRequest $request, string $method) =>
                    new SoapRequest(
                        $request->getRequest(),
                        in_array($method, $this->wireMockMethods, true)
                            ? rtrim(self::getEnvironmentVariable('TWINT_SDK_TEST_WIREMOCK_BASE_URL'), '/')
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
    protected function enableWireMockForSoapMethod(string ...$methods): void
    {
        $this->wireMockMethods = array_unique(array_values([...$this->wireMockMethods, ...$methods]));
    }

    protected function wireMock(): WireMock
    {
        return $this->wireMock ??= $this->createWireMock();
    }

    private function createWireMock(): WireMock
    {
        $baseUrl = self::getEnvironmentVariable('TWINT_SDK_TEST_WIREMOCK_BASE_URL');
        $urlParts = shape([
            'host' => non_empty_string(),
            'port' => optional(uint()),
            'scheme' => non_empty_string(),
        ], true)->assert(parse_url($baseUrl));

        $curl = new Curl(new TokenAuthenticator(self::getEnvironmentVariable('TWINT_SDK_TEST_WIREMOCK_AUTH_TOKEN')));
        $httpWait = new HttpWait($curl);
        return new WireMock(
            $httpWait,
            $curl,
            SerializerFactory::default(),
            $urlParts['host'],
            $urlParts['port'] ?? ($urlParts['scheme'] === 'https' ? 443 : 80),
            $urlParts['scheme']
        );
    }
}
