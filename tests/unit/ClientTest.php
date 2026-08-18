<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit;

use Exception;
use Phpro\SoapClient\Exception\SoapException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\DoesNotPerformAssertions;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Soap\Engine\Engine;
use SoapFault;
use Twint\Sdk\Certificate\CertificateContainer;
use Twint\Sdk\Certificate\Pkcs8Certificate;
use Twint\Sdk\Client;
use Twint\Sdk\Exception\ApiFailure;
use Twint\Sdk\Exception\CancellationFailed;
use Twint\Sdk\Generated\Type\CodeValueType;
use Twint\Sdk\Generated\Type\EnrollCashRegisterRequestElement;
use Twint\Sdk\Generated\Type\EnrollCashRegisterResponseType;
use Twint\Sdk\Generated\Type\OrderStatusType;
use Twint\Sdk\Generated\Type\StartOrderRequestElement;
use Twint\Sdk\Generated\Type\StartOrderResponseType;
use Twint\Sdk\Io\FileWriter;
use Twint\Sdk\Io\InMemoryStream;
use Twint\Sdk\Io\TemporaryFileWriter;
use Twint\Sdk\Soap\ErrorClassifier;
use Twint\Sdk\Tools\ClientResetter;
use Twint\Sdk\Value\AlphanumericPairingToken;
use Twint\Sdk\Value\CustomerDataScopes;
use Twint\Sdk\Value\Environment;
use Twint\Sdk\Value\FiledMerchantTransactionReference;
use Twint\Sdk\Value\IosAppScheme;
use Twint\Sdk\Value\Money;
use Twint\Sdk\Value\NumericPairingToken;
use Twint\Sdk\Value\PairingToken;
use Twint\Sdk\Value\PairingUuid;
use Twint\Sdk\Value\PrefixedCashRegisterId;
use Twint\Sdk\Value\ShippingMethods;
use Twint\Sdk\Value\StoreUuid;
use Twint\Sdk\Value\UnfiledMerchantTransactionReference;
use Twint\Sdk\Value\Version;
use function Psl\Type\instance_of;
use function Psl\Type\mixed;
use function Psl\Type\non_empty_vec;
use function Psl\Type\union;

/**
 * @internal
 */
#[CoversClass(Client::class)]
#[CoversClass(ApiFailure::class)]
#[CoversClass(CancellationFailed::class)]
final class ClientTest extends TestCase
{
    /**
     * @return iterable<array{string, list<mixed>}>
     */
    public static function getExceptionCases(): iterable
    {
        yield ['checkSystemStatus', []];
        yield ['startOrder', [new UnfiledMerchantTransactionReference('ref'), Money::CHF(100)]];
        yield ['monitorOrder', [new FiledMerchantTransactionReference('ref')]];
        yield ['cancelOrder', [new FiledMerchantTransactionReference('ref')]];
        yield ['confirmOrder', [new FiledMerchantTransactionReference('ref'), Money::CHF(100)]];
        yield [
            'reverseOrder',
            [
                new UnfiledMerchantTransactionReference('rev'),
                new FiledMerchantTransactionReference('ref'),
                Money::CHF(100),
            ],
        ];
        yield [
            'requestFastCheckOutCheckIn',
            [Money::CHF(10), new CustomerDataScopes(CustomerDataScopes::DATE_OF_BIRTH), new ShippingMethods()],
        ];
        yield ['monitorFastCheckOutCheckIn', [PairingUuid::fromString('f1b4b3b4-0b3b-4b3b-8b3b-0b3b4b3b4b3b')]];
        yield ['cancelFastCheckOutCheckIn', [PairingUuid::fromString('f1b4b3b4-0b3b-4b3b-8b3b-0b3b4b3b4b3b')]];
        yield [
            'startFastCheckoutOrder',
            [
                PairingUuid::fromString('f1b4b3b4-0b3b-4b3b-8b3b-0b3b4b3b4b3b'),
                new UnfiledMerchantTransactionReference('ref'),
                Money::CHF(100),
            ],
        ];
        yield ['startHostedOrder', [new UnfiledMerchantTransactionReference('ref'), Money::CHF(100)]];
        yield [
            'requestHostedFastCheckoutCheckIn',
            [Money::CHF(10), new CustomerDataScopes(CustomerDataScopes::DATE_OF_BIRTH), new ShippingMethods()],
        ];
    }

    /**
     * @return iterable<string, array{0: non-empty-string, 1: PairingToken<scalar>, 2: non-empty-string}>
     */
    public static function getIosAppLinks(): iterable
    {
        yield 'numeric pairing token' => [
            'twint-issuer42://',
            new NumericPairingToken(12345),
            'twint-issuer42://applinks/?al_applink_data={"app_action_type":"TWINT_PAYMENT",'
            . '"extras":{"code":"12345"},"referer_app_link":{"target_url":"","url":"",'
            . '"app_name":"EXTERNAL_WEB_BROWSER"},"version":"6.0"}',
        ];

        yield 'alphanumeric pairing token' => [
            'twint-issuer7://',
            new AlphanumericPairingToken('AB12CD'),
            'twint-issuer7://applinks/?al_applink_data={"app_action_type":"TWINT_PAYMENT",'
            . '"extras":{"code":"AB12CD"},"referer_app_link":{"target_url":"","url":"",'
            . '"app_name":"EXTERNAL_WEB_BROWSER"},"version":"6.0"}',
        ];
    }

    /**
     * @param list<mixed> $args
     */
    #[DataProvider('getExceptionCases')]
    public function testSoapExceptionsAsApiFailure(string $method, array $args): void
    {
        $engine = $this->createMock(Engine::class);
        $engine
            ->expects(self::atLeastOnce())
            ->method('request')
            ->willReturnCallback(static function (string $soapMethod, array $args) {
                return match (true) {
                    $soapMethod === 'EnrollCashRegister' => new EnrollCashRegisterResponseType(),
                    default => throw new SoapException(),
                };
            });

        $client = new Client(
            CertificateContainer::fromPem(new Pkcs8Certificate(new InMemoryStream('cert'), 'pass')),
            StoreUuid::fromString('3094877c-352c-4bed-b542-bb69c7c4608c'),
            Version::LATEST,
            Environment::TESTING,
            new TemporaryFileWriter(),
            static fn () => $engine
        );

        $this->expectException(ApiFailure::class);

        // @phpstan-ignore-next-line
        $client->{$method}(...$args);
    }

    public function testSoapExceptionAsApiFailureWithImplicitCashRegisterEnrollment(): void
    {
        $engine = $this->createMock(Engine::class);
        $engine
            ->expects(self::atLeastOnce())
            ->method('request')
            ->willThrowException(new SoapException());

        $client = new Client(
            CertificateContainer::fromPem(new Pkcs8Certificate(new InMemoryStream('cert'), 'pass')),
            StoreUuid::fromString('3094877c-352c-4bed-b542-bb69c7c4608c'),
            Version::LATEST,
            Environment::TESTING,
            new TemporaryFileWriter(),
            static fn () => $engine
        );

        ClientResetter::reset($client);

        $this->expectException(ApiFailure::class);

        $client->startOrder(new UnfiledMerchantTransactionReference('ref'), Money::CHF(100));
    }

    public function testCashRegisterIdForImplicitEnrollmentIsCombinedPrefixWithStoreUuid(): void
    {
        $engine = $this->createMock(Engine::class);
        $engine
            ->expects(self::exactly(2))
            ->method('request')
            ->willReturnCallback(
                static function (string $soapMethod, array $args) {
                    /**
                     * @var EnrollCashRegisterRequestElement|StartOrderRequestElement
                     */
                    [$request] = non_empty_vec(mixed())->assert($args);

                    union(
                        instance_of(EnrollCashRegisterRequestElement::class),
                        instance_of(StartOrderRequestElement::class)
                    )->assert($request);

                    self::assertSame(
                        'Magento-3094877c-352c-4bed-b542-bb69c7c4608c',
                        $request->getMerchantInformation()
                            ->getCashRegisterId()
                    );

                    return match ($soapMethod) {
                        'EnrollCashRegister' => new EnrollCashRegisterResponseType(),
                        'StartOrder' => self::createOrderSoapResponse(),
                        default => null,
                    };
                }
            );

        $client = new Client(
            CertificateContainer::fromPem(new Pkcs8Certificate(new InMemoryStream('cert'), 'pass')),
            new PrefixedCashRegisterId(StoreUuid::fromString('3094877c-352c-4bed-b542-bb69c7c4608c'), 'Magento'),
            Version::LATEST,
            Environment::TESTING,
            new TemporaryFileWriter(),
            static fn () => $engine
        );

        ClientResetter::reset($client);

        $client->startOrder(new UnfiledMerchantTransactionReference('ref'), Money::CHF(100));
    }

    public function testCashRegisterIdForImplicitEnrollmentDefaultIsUnknown(): void
    {
        $engine = $this->createMock(Engine::class);
        $engine
            ->expects(self::exactly(2))
            ->method('request')
            ->willReturnCallback(
                static function (string $soapMethod, array $args) {
                    /**
                     * @var EnrollCashRegisterRequestElement|StartOrderRequestElement
                     */
                    [$request] = non_empty_vec(mixed())->assert($args);

                    union(
                        instance_of(EnrollCashRegisterRequestElement::class),
                        instance_of(StartOrderRequestElement::class)
                    )->assert($request);

                    self::assertSame(
                        'Unknown-3094877c-352c-4bed-b542-bb69c7c4608c',
                        $request->getMerchantInformation()
                            ->getCashRegisterId()
                    );

                    return match ($soapMethod) {
                        'EnrollCashRegister' => new EnrollCashRegisterResponseType(),
                        'StartOrder' => self::createOrderSoapResponse(),
                        default => null,
                    };
                }
            );

        $client = new Client(
            CertificateContainer::fromPem(new Pkcs8Certificate(new InMemoryStream('cert'), 'pass')),
            StoreUuid::fromString('3094877c-352c-4bed-b542-bb69c7c4608c'),
            Version::LATEST,
            Environment::TESTING,
            new TemporaryFileWriter(),
            static fn () => $engine
        );

        ClientResetter::reset($client);

        $client->startOrder(new UnfiledMerchantTransactionReference('ref'), Money::CHF(100));
    }

    public function testCashRegisterEnrollmentIsOnlyInvokedOnce(): void
    {
        $engine = $this->createMock(Engine::class);
        $engine
            ->expects(self::exactly(4))
            ->method('request')
            ->willReturnOnConsecutiveCalls(
                new EnrollCashRegisterResponseType(),
                self::createOrderSoapResponse(),
                self::createOrderSoapResponse(),
                self::createOrderSoapResponse(),
            );

        $client = new Client(
            CertificateContainer::fromPem(new Pkcs8Certificate(new InMemoryStream('cert'), 'pass')),
            StoreUuid::fromString('3094877c-352c-4bed-b542-bb69c7c4608c'),
            Version::LATEST,
            Environment::TESTING,
            new TemporaryFileWriter(),
            static fn () => $engine
        );

        ClientResetter::reset($client);

        $client->startOrder(new UnfiledMerchantTransactionReference('ref'), Money::CHF(100));
        $client->startOrder(new UnfiledMerchantTransactionReference('ref'), Money::CHF(100));


        $client = new Client(
            CertificateContainer::fromPem(new Pkcs8Certificate(new InMemoryStream('cert'), 'pass')),
            StoreUuid::fromString('3094877c-352c-4bed-b542-bb69c7c4608c'),
            Version::LATEST,
            Environment::TESTING,
            new TemporaryFileWriter(),
            static fn () => $engine
        );
        $client->startOrder(new UnfiledMerchantTransactionReference('ref'), Money::CHF(100));
    }

    public function testSpecificExceptionOnCancellationFailure(): void
    {
        $fault = new SoapFault('code', 'message');
        $exception = SoapException::fromThrowable($fault);

        $engine = $this->createMock(Engine::class);
        $engine
            ->expects(self::exactly(2))
            ->method('request')
            ->willReturnOnConsecutiveCalls(new EnrollCashRegisterResponseType(), self::throwException($fault));

        $errorClassifier = $this->createMock(ErrorClassifier::class);
        $errorClassifier
            ->expects(self::once())
            ->method('isOfType')
            ->with($exception, ErrorClassifier::STATUS_TRANSITION_ERROR)
            ->willReturn(true);

        $client = new Client(
            CertificateContainer::fromPem(new Pkcs8Certificate(new InMemoryStream('cert'), 'pass')),
            StoreUuid::fromString('3094877c-352c-4bed-b542-bb69c7c4608a'),
            Version::LATEST,
            Environment::TESTING,
            new TemporaryFileWriter(),
            static fn () => $engine,
            errorClassifier: $errorClassifier
        );

        $this->expectException(CancellationFailed::class);
        $client->cancelOrder(new FiledMerchantTransactionReference('ref'));
    }

    public function testEnrollmentIsRepeatedForDifferentEnvironments(): void
    {
        $storeUuid = StoreUuid::fromString('3094877c-352c-4bed-b542-bb69c7c4608c');

        // TESTING client: expects EnrollCashRegister + StartOrder
        $testingEngine = $this->createMock(Engine::class);
        $testingEngine
            ->method('request')
            ->willReturnCallback(static function (string $method) {
                return match ($method) {
                    'EnrollCashRegister' => new EnrollCashRegisterResponseType(),
                    'StartOrder' => self::createOrderSoapResponse(),
                    default => null,
                };
            });

        $testingClient = new Client(
            CertificateContainer::fromPem(new Pkcs8Certificate(new InMemoryStream('cert'), 'pass')),
            $storeUuid,
            Version::LATEST,
            Environment::TESTING,
            new TemporaryFileWriter(),
            static fn () => $testingEngine,
        );

        ClientResetter::reset($testingClient);

        $testingClient->startOrder(new UnfiledMerchantTransactionReference('ref'), Money::CHF(100));

        // PRODUCTION client with same store UUID: should also enroll, because
        // enrollment in TESTING does not imply enrollment in PRODUCTION.
        // BUG: the static cache is keyed only on cash register ID, so enrollment
        // is skipped for PRODUCTION since TESTING already cached this ID.
        $productionEnrollCalled = false;
        $productionEngine = $this->createMock(Engine::class);
        $productionEngine
            ->method('request')
            ->willReturnCallback(static function (string $method) use (&$productionEnrollCalled) {
                if ($method === 'EnrollCashRegister') {
                    $productionEnrollCalled = true;
                }

                return match ($method) {
                    'EnrollCashRegister' => new EnrollCashRegisterResponseType(),
                    'StartOrder' => self::createOrderSoapResponse(),
                    default => null,
                };
            });

        $productionClient = new Client(
            CertificateContainer::fromPem(new Pkcs8Certificate(new InMemoryStream('cert'), 'pass')),
            $storeUuid,
            Version::LATEST,
            Environment::PRODUCTION,
            new TemporaryFileWriter(),
            static fn () => $productionEngine,
        );

        $productionClient->startOrder(new UnfiledMerchantTransactionReference('ref'), Money::CHF(100));

        self::assertTrue($productionEnrollCalled, 'Expected EnrollCashRegister to be called for PRODUCTION client');
    }

    private static function createOrderSoapResponse(): StartOrderResponseType
    {
        return (new StartOrderResponseType())
            ->withOrderUuid('00000000-0000-0000-0000-000000000000')
            ->withOrderStatus(
                (new OrderStatusType())
                    ->withStatus((new CodeValueType())->with_('SUCCESS')->withCode(0))
                    ->withReason((new CodeValueType())->with_('ORDER_OK')->withCode(0))
            )->withPairingStatus('NO_PAIRING')
            ->withToken(1234)
            ->withQRCode('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABKklEQVR42mNk');
    }

    #[DoesNotPerformAssertions]
    public function testCreateClientWithFileWriterFactory(): void
    {
        new Client(
            CertificateContainer::fromPem(new Pkcs8Certificate(new InMemoryStream('cert'), 'pass')),
            StoreUuid::fromString('3094877c-352c-4bed-b542-bb69c7c4608c'),
            Version::LATEST,
            Environment::TESTING,
            fn (): FileWriter => $this->createMock(FileWriter::class)
        );
    }

    public function testGetIosAppSchemesThrowsApiFailureOnRequestFailure(): void
    {
        $client = new Client(
            CertificateContainer::fromPem(new Pkcs8Certificate(new InMemoryStream('cert'), 'pass')),
            StoreUuid::fromString('3094877c-352c-4bed-b542-bb69c7c4608c'),
            Version::LATEST,
            Environment::TESTING,
            httpClientFactory: static fn () => throw new class(
                'Mocked error'
            ) extends Exception implements ClientExceptionInterface {},
        );

        $this->expectException(ApiFailure::class);
        $client->getIosAppSchemes();
    }

    public function testGetIosAppSchemesThrowsApiFailureWhenResponseCannotBeParsed(): void
    {
        $client = new Client(
            CertificateContainer::fromPem(new Pkcs8Certificate(new InMemoryStream('cert'), 'pass')),
            StoreUuid::fromString('3094877c-352c-4bed-b542-bb69c7c4608c'),
            Version::LATEST,
            Environment::TESTING,
            httpClientFactory: fn () => $this->createConfiguredMock(ClientInterface::class, [
                'sendRequest' => $this->createConfiguredMock(ResponseInterface::class, [
                    'getStatusCode' => 200,
                    'getHeader' => ['application/json'],
                    'getBody' => $this->createConfiguredMock(
                        StreamInterface::class,
                        [
                            'getContents' => 'invalid',
                        ]
                    ),
                ]),
            ]),
        );

        $this->expectException(ApiFailure::class);
        $client->getIosAppSchemes();
    }

    /**
     * @param non-empty-string $scheme
     * @param PairingToken<scalar> $token
     * @param non-empty-string $expectedUrl
     */
    #[DataProvider('getIosAppLinks')]
    public function testIosAppUrlCarriesThePairingTokenOnTheIssuerScheme(
        string $scheme,
        PairingToken $token,
        string $expectedUrl
    ): void {
        self::assertSame(
            $expectedUrl,
            (string) self::createClientWithoutTransport()->getIosAppUrl(
                new IosAppScheme($scheme, 'Some Issuer'),
                $token
            )
        );
    }

    public function testIosAppUrlIsBuiltWithoutTalkingToTheApi(): void
    {
        $engine = $this->createMock(Engine::class);
        $engine->expects(self::never())
            ->method('request');
        $httpClient = $this->createMock(ClientInterface::class);
        $httpClient->expects(self::never())
            ->method('sendRequest');

        $client = new Client(
            CertificateContainer::fromPem(new Pkcs8Certificate(new InMemoryStream('cert'), 'pass')),
            StoreUuid::fromString('3094877c-352c-4bed-b542-bb69c7c4608c'),
            Version::LATEST,
            Environment::TESTING,
            new TemporaryFileWriter(),
            static fn () => $engine,
            static fn () => $httpClient,
        );

        $url = $client->getIosAppUrl(new IosAppScheme('twint-issuer1://', 'Some Issuer'), new NumericPairingToken(1));

        self::assertStringStartsWith('twint-issuer1://applinks/?', (string) $url);
    }

    private static function createClientWithoutTransport(): Client
    {
        return new Client(
            CertificateContainer::fromPem(new Pkcs8Certificate(new InMemoryStream('cert'), 'pass')),
            StoreUuid::fromString('3094877c-352c-4bed-b542-bb69c7c4608c'),
            Version::LATEST,
            Environment::TESTING,
            new TemporaryFileWriter(),
        );
    }
}
