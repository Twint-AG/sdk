<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit;

use Phpro\SoapClient\Exception\SoapException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Soap\Engine\Engine;
use SoapFault;
use Twint\Sdk\Certificate\CertificateContainer;
use Twint\Sdk\Certificate\PemCertificate;
use Twint\Sdk\Client;
use Twint\Sdk\Exception\ApiFailure;
use Twint\Sdk\Exception\CancellationFailed;
use Twint\Sdk\Generated\Type\CodeValueType;
use Twint\Sdk\Generated\Type\EnrollCashRegisterRequestElement;
use Twint\Sdk\Generated\Type\EnrollCashRegisterResponseType;
use Twint\Sdk\Generated\Type\OrderStatusType;
use Twint\Sdk\Generated\Type\StartOrderRequestElement;
use Twint\Sdk\Generated\Type\StartOrderResponseType;
use Twint\Sdk\Io\InMemoryStream;
use Twint\Sdk\Io\TemporaryFileWriter;
use Twint\Sdk\Soap\ErrorClassifier;
use Twint\Sdk\Value\CustomerDataScopes;
use Twint\Sdk\Value\Environment;
use Twint\Sdk\Value\FiledMerchantTransactionReference;
use Twint\Sdk\Value\Money;
use Twint\Sdk\Value\PairingUuid;
use Twint\Sdk\Value\PrefixedCashRegisterId;
use Twint\Sdk\Value\ShippingMethods;
use Twint\Sdk\Value\StoreUuid;
use Twint\Sdk\Value\UnfiledMerchantTransactionReference;
use Twint\Sdk\Value\Version;
use function Psl\Type\instance_of;
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
    }

    /**
     * @param array<mixed> $args
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
            CertificateContainer::fromPem(new PemCertificate(new InMemoryStream('cert'), 'pass')),
            StoreUuid::fromString('3094877c-352c-4bed-b542-bb69c7c4608c'),
            Version::latest(),
            Environment::TESTING(),
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
            CertificateContainer::fromPem(new PemCertificate(new InMemoryStream('cert'), 'pass')),
            StoreUuid::fromString('3094877c-352c-4bed-b542-bb69c7c4608c'),
            Version::latest(),
            Environment::TESTING(),
            new TemporaryFileWriter(),
            static fn () => $engine
        );

        $prop = (new ReflectionClass(Client::class))->getProperty('enrolledCashRegisters');
        $prop->setAccessible(true);
        $prop->setValue($client, []);

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
                     * @var EnrollCashRegisterRequestElement|StartOrderRequestElement $request
                     */
                    [$request] = $args;

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
            CertificateContainer::fromPem(new PemCertificate(new InMemoryStream('cert'), 'pass')),
            new PrefixedCashRegisterId(StoreUuid::fromString('3094877c-352c-4bed-b542-bb69c7c4608c'), 'Magento'),
            Version::latest(),
            Environment::TESTING(),
            new TemporaryFileWriter(),
            static fn () => $engine
        );

        $prop = (new ReflectionClass(Client::class))->getProperty('enrolledCashRegisters');
        $prop->setAccessible(true);
        $prop->setValue($client, []);

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
                     * @var EnrollCashRegisterRequestElement|StartOrderRequestElement $request
                     */
                    [$request] = $args;

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
            CertificateContainer::fromPem(new PemCertificate(new InMemoryStream('cert'), 'pass')),
            StoreUuid::fromString('3094877c-352c-4bed-b542-bb69c7c4608c'),
            Version::latest(),
            Environment::TESTING(),
            new TemporaryFileWriter(),
            static fn () => $engine
        );

        $prop = (new ReflectionClass(Client::class))->getProperty('enrolledCashRegisters');
        $prop->setAccessible(true);
        $prop->setValue($client, []);

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
            CertificateContainer::fromPem(new PemCertificate(new InMemoryStream('cert'), 'pass')),
            StoreUuid::fromString('3094877c-352c-4bed-b542-bb69c7c4608c'),
            Version::latest(),
            Environment::TESTING(),
            new TemporaryFileWriter(),
            static fn () => $engine
        );

        $prop = (new ReflectionClass(Client::class))->getProperty('enrolledCashRegisters');
        $prop->setAccessible(true);
        $prop->setValue($client, []);


        $client->startOrder(new UnfiledMerchantTransactionReference('ref'), Money::CHF(100));
        $client->startOrder(new UnfiledMerchantTransactionReference('ref'), Money::CHF(100));


        $client = new Client(
            CertificateContainer::fromPem(new PemCertificate(new InMemoryStream('cert'), 'pass')),
            StoreUuid::fromString('3094877c-352c-4bed-b542-bb69c7c4608c'),
            Version::latest(),
            Environment::TESTING(),
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
            CertificateContainer::fromPem(new PemCertificate(new InMemoryStream('cert'), 'pass')),
            StoreUuid::fromString('3094877c-352c-4bed-b542-bb69c7c4608a'),
            Version::latest(),
            Environment::TESTING(),
            new TemporaryFileWriter(),
            static fn () => $engine,
            errorClassifier: $errorClassifier
        );

        $this->expectException(CancellationFailed::class);
        $client->cancelOrder(new FiledMerchantTransactionReference('ref'));
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
}
