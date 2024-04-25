<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Integration;

use Override;
use PHPUnit\Framework\TestCase;
use Soap\Engine\Encoder;
use Soap\Engine\HttpBinding\SoapRequest;
use Twint\Sdk\Capability\Capability;
use Twint\Sdk\Certificate;
use Twint\Sdk\Client;
use Twint\Sdk\Factory\DefaultHttpClientFactory;
use Twint\Sdk\Factory\DefaultSoapEngineFactory;
use Twint\Sdk\Io\ContentSensitiveFileWriter;
use Twint\Sdk\Io\FileStream;
use Twint\Sdk\Soap\RequestModifyingEncoder;
use Twint\Sdk\Tools\SystemEnvironment;
use Twint\Sdk\Tools\WireMock\DefaultWireMockFactory;
use Twint\Sdk\Value\Environment;
use Twint\Sdk\Value\ExistingPath;
use Twint\Sdk\Value\MerchantId;
use Twint\Sdk\Value\UnfiledMerchantTransactionReference;
use Twint\Sdk\Value\Uuid;
use Twint\Sdk\Value\Version;
use WireMock\Client\WireMock;

/**
 * @template T of Capability
 */
abstract class IntegrationTest extends TestCase
{
    final protected const SOAP_REQUEST_MATCHERS = ['method', 'url', 'host', 'body', 'soap_operation'];

    /**
     * @var T
     */
    protected readonly Capability $client;

    private ?WireMock $wireMock = null;

    /**
     * @var list<non-empty-string>
     */
    private array $wireMockMethods = [];

    final protected static function getMerchantId(): MerchantId
    {
        return MerchantId::fromString(SystemEnvironment::get('TWINT_SDK_TEST_MERCHANT_ID'));
    }

    final protected function createTransactionReference(): UnfiledMerchantTransactionReference
    {
        return new UnfiledMerchantTransactionReference(substr(hash('sha3-256', random_bytes(32)), 0, 50));
    }

    #[Override]
    final protected function setUp(): void
    {
        $client = new Client(
            Certificate\CertificateContainer::fromPkcs12(
                new Certificate\Pkcs12Certificate(
                    new FileStream(new ExistingPath(SystemEnvironment::get('TWINT_SDK_TEST_CERT_P12_PATH'))),
                    SystemEnvironment::get('TWINT_SDK_TEST_CERT_P12_PASSPHRASE')
                )
            ),
            self::getMerchantId(),
            Version::latest(),
            Environment::TESTING(),
            new ContentSensitiveFileWriter(
                new ExistingPath(__DIR__ . '/../../build/'),
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
                            ? rtrim(SystemEnvironment::get('TWINT_SDK_TEST_WIREMOCK_BASE_URL'), '/')
                            . parse_url($request->getLocation(), PHP_URL_PATH)
                            : $request->getLocation(),
                        $request->getAction(),
                        $request->getVersion(),
                        $request->getOneWay()
                    )
                )
            )
        );
        // @phpstan-ignore-next-line
        $this->client = $client;
    }

    /**
     * @param non-empty-string ...$methods
     */
    final protected function enableWireMockForSoapMethod(string ...$methods): void
    {
        $this->wireMockMethods = array_values(array_unique([...$this->wireMockMethods, ...$methods]));
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
