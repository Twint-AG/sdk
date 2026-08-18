<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Integration;

use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use Soap\Engine\Encoder;
use Soap\Engine\HttpBinding\SoapRequest;
use Soap\Engine\Transport;
use Twint\Sdk\Capability\Capability;
use Twint\Sdk\Certificate;
use Twint\Sdk\Client;
use Twint\Sdk\Factory\DefaultHttpClientFactory;
use Twint\Sdk\Factory\DefaultSoapEngineFactory;
use Twint\Sdk\Io\ContentSensitiveFileWriter;
use Twint\Sdk\Io\FileStream;
use Twint\Sdk\Io\FileWriter;
use Twint\Sdk\Io\NonEmptyStream;
use Twint\Sdk\Soap\RequestModifyingEncoder;
use Twint\Sdk\Tools\Hermeticism\Empirical;
use Twint\Sdk\Tools\Hermeticism\HermeticHttpClient;
use Twint\Sdk\Tools\Hermeticism\Hermeticism;
use Twint\Sdk\Tools\Hermeticism\LoggingHttpClient;
use Twint\Sdk\Tools\SystemEnvironment;
use Twint\Sdk\Tools\WireMock\DefaultWireMockFactory;
use Twint\Sdk\Util\Resilience;
use Twint\Sdk\Value\Environment;
use Twint\Sdk\Value\ExistingPath;
use Twint\Sdk\Value\InstallSource;
use Twint\Sdk\Value\PlatformVersion;
use Twint\Sdk\Value\PluginVersion;
use Twint\Sdk\Value\ShopPlatform;
use Twint\Sdk\Value\ShopPluginInformation;
use Twint\Sdk\Value\StoreUuid;
use Twint\Sdk\Value\UnfiledMerchantTransactionReference;
use Twint\Sdk\Value\Version;
use WireMock\Client\WireMock;
use function Psl\Type\non_empty_string;
use function Psl\Type\uint;

/**
 * @template T of Capability
 */
abstract class IntegrationTest extends TestCase
{
    final protected const SOAP_REQUEST_MATCHERS = ['method', 'url', 'host', 'body', 'soap_operation'];

    private ?WireMock $wireMock = null;

    /**
     * @var list<non-empty-string>
     */
    private array $wireMockMethods = [];

    /**
     * @return T
     */
    public function createClient(?Version $version = null): object
    {
        $client = new Client(
            Certificate\CertificateContainer::fromPkcs12(
                new Certificate\Pkcs12Certificate(
                    new NonEmptyStream(
                        new FileStream(new ExistingPath(SystemEnvironment::get('TWINT_SDK_TEST_CERT_P12_PATH')))
                    ),
                    SystemEnvironment::get('TWINT_SDK_TEST_CERT_P12_PASSPHRASE')
                )
            ),
            new ShopPluginInformation(
                self::getStoreUuid(),
                ShopPlatform::OTHER(),
                new PlatformVersion('dev-master'),
                new PluginVersion('9.9.9-dev'),
                InstallSource::DIRECT()
            ),
            $version ?? Version::latest(),
            Environment::TESTING(),
            new ContentSensitiveFileWriter(
                new ExistingPath(__DIR__ . '/../../build/'),
                static function (string $content) {
                    $fingerprint = openssl_x509_fingerprint($content);

                    return $fingerprint !== false ? $fingerprint : hash('sha3-384', $content);
                }
            ),
            new DefaultSoapEngineFactory(
                wrapEncoder: fn (Encoder $encoder) => new RequestModifyingEncoder(
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
                ),
                wrapTransport: [$this, 'wrapTransport'],
                createHttpClient: self::instrumentedHttpClientFactory(),
            ),
            httpClientFactory: self::instrumentedHttpClientFactory(),
        );

        // @phpstan-ignore-next-line
        return $client;
    }

    final protected static function getStoreUuid(): StoreUuid
    {
        return StoreUuid::fromString(SystemEnvironment::get('TWINT_SDK_TEST_STORE_UUID'));
    }

    final protected static function createTransactionReference(): UnfiledMerchantTransactionReference
    {
        return new UnfiledMerchantTransactionReference(
            substr(hash('sha3-256', non_empty_string()->assert(random_bytes(32))), 0, 50)
        );
    }

    private static function responseLogPath(): ?string
    {
        $path = $_SERVER[Empirical::LOG_ENV_VAR] ?? '';

        return is_string($path) && $path !== '' ? $path : null;
    }

    /**
     * Guards every outgoing request against {@see Hermeticism}, and logs the responses
     * when {@see Empirical::LOG_ENV_VAR} names a file to write them to.
     *
     * Applied at the PSR-18 layer rather than around the transport, because
     * {@see self::wrapTransport()} is an overridable hook and a subclass replacing it
     * would otherwise silently drop both.
     *
     * @return callable(FileWriter, ?Certificate\CertificateContainer=): ClientInterface
     */
    private static function instrumentedHttpClientFactory(): callable
    {
        $factory = new DefaultHttpClientFactory();

        return static function (
            FileWriter $writer,
            ?Certificate\CertificateContainer $certificate = null
        ) use ($factory): ClientInterface {
            $client = new HermeticHttpClient($factory($writer, $certificate));
            $logPath = self::responseLogPath();

            return $logPath === null ? $client : new LoggingHttpClient($client, $logPath);
        };
    }

    /**
     * Every order operation is preceded by an EnrollCashRegister call, so a test that stubs
     * any SOAP operation has to stub that one too or it still reaches the real API.
     *
     * @param non-empty-string ...$methods
     */
    final protected function enableWireMockForSoapMethod(string ...$methods): void
    {
        $this->wireMockMethods = array_values(
            array_unique([...$this->wireMockMethods, ...$methods, 'EnrollCashRegister'])
        );
    }

    final protected function wireMock(): WireMock
    {
        return $this->wireMock ??= self::createWireMock();
    }

    protected static function createWireMock(): WireMock
    {
        return (new DefaultWireMockFactory())();
    }

    public function wrapTransport(Transport $transport): Transport
    {
        return $transport;
    }

    /**
     * @template TReturn
     * @param callable(): TReturn $operation
     * @return TReturn
     */
    protected static function retry(callable $operation): mixed
    {
        $ciNodeIndex = getenv('CI_NODE_INDEX');
        $ciNodeDelay = $ciNodeIndex === false ? 0 : uint()
            ->coerce($ciNodeIndex) * 50;

        return Resilience::retry(10, $operation, 100 + $ciNodeDelay);
    }
}
