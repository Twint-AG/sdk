<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit;

use Phpro\SoapClient\Exception\SoapException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Soap\Engine\Engine;
use Twint\Sdk\Certificate\CertificateContainer;
use Twint\Sdk\Certificate\PemCertificate;
use Twint\Sdk\Client;
use Twint\Sdk\Exception\ApiFailure;
use Twint\Sdk\Generated\Type\EnrollCashRegisterResponseType;
use Twint\Sdk\Io\InMemoryStream;
use Twint\Sdk\Io\TemporaryFileWriter;
use Twint\Sdk\Value\CustomerDataScopes;
use Twint\Sdk\Value\Environment;
use Twint\Sdk\Value\FiledMerchantTransactionReference;
use Twint\Sdk\Value\MerchantId;
use Twint\Sdk\Value\Money;
use Twint\Sdk\Value\PairingUuid;
use Twint\Sdk\Value\ShippingMethods;
use Twint\Sdk\Value\UnfiledMerchantTransactionReference;
use Twint\Sdk\Value\Version;

/**
 * @internal
 */
#[CoversClass(Client::class)]
#[CoversClass(ApiFailure::class)]
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
            MerchantId::fromString('3094877c-352c-4bed-b542-bb69c7c4608c'),
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
            MerchantId::fromString('3094877c-352c-4bed-b542-bb69c7c4608c'),
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
}
