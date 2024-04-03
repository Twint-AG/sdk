<?php

declare(strict_types=1);

namespace Twint\Sdk;

use DateTimeImmutable;

use Http\Discovery\Psr17FactoryDiscovery;
use Phpro\SoapClient\Caller\EngineCaller;
use Phpro\SoapClient\Exception\SoapException;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Soap\Engine\Engine;
use Throwable;
use Twint\Sdk\Certificate\CertificateContainer;
use Twint\Sdk\Certificate\InMemoryStream;
use Twint\Sdk\Certificate\Pkcs12Certificate;
use Twint\Sdk\Exception\ApiFailure;
use Twint\Sdk\Exception\SdkError;
use Twint\Sdk\Factory\DefaultHttpClientFactory;
use Twint\Sdk\Factory\DefaultSoapEngineFactory;
use Twint\Sdk\File\FileWriter;
use Twint\Sdk\File\TemporaryFileWriter;
use Twint\Sdk\Generated\TwintSoapClient;
use Twint\Sdk\Generated\Type\ConfirmOrderRequestType;
use Twint\Sdk\Generated\Type\CurrencyAmountType;
use Twint\Sdk\Generated\Type\EnrollCashRegisterRequestType;
use Twint\Sdk\Generated\Type\GetCertificateValidityRequestType;
use Twint\Sdk\Generated\Type\MerchantInformationType;
use Twint\Sdk\Generated\Type\MonitorOrderRequestType;
use Twint\Sdk\Generated\Type\OrderRequestType;
use Twint\Sdk\Generated\Type\RenewCertificateRequestType;
use Twint\Sdk\Generated\Type\StartOrderRequestType;
use Twint\Sdk\Value\CertificateRenewal;
use Twint\Sdk\Value\CertificateValidity;
use Twint\Sdk\Value\DetectedDevice;
use Twint\Sdk\Value\IosAppScheme;
use Twint\Sdk\Value\MerchantId;
use Twint\Sdk\Value\Money;
use Twint\Sdk\Value\Order;
use Twint\Sdk\Value\OrderId;
use Twint\Sdk\Value\OrderKind;
use Twint\Sdk\Value\OrderStatus;
use Twint\Sdk\Value\TransactionReference;
use Twint\Sdk\Value\TransactionStatus;
use function Psl\invariant;
use function Psl\Type\non_empty_string;
use function Psl\Type\shape;
use function Psl\Type\string;
use function Psl\Type\vec;

final class ApiClient implements Client
{
    private const POSTING_TYPE_GOODS = 'GOODS';

    private const CASH_REGISTER_TYPE_EPOS = 'EPOS';

    private ?TwintSoapClient $soapClient = null;

    private ?ClientInterface $httpClient = null;

    private ?RequestFactoryInterface $httpRequestFactory = null;

    /**
     * @var list<string>
     */
    private static array $enrolledCacheRegisters = [];

    /**
     * @param callable(FileWriter, CertificateContainer, TwintVersion, TwintEnvironment): Engine $soapEngineFactory
     * @param callable(FileWriter, CertificateContainer): ClientInterface $httpClientFactory
     * @param callable(): RequestFactoryInterface $httpRequestFactoryFactory
     */
    public function __construct(
        private CertificateContainer $certificate,
        private readonly TwintVersion $version,
        private readonly TwintEnvironment $environment,
        private readonly FileWriter $fileWriter = new TemporaryFileWriter(),
        private readonly mixed $soapEngineFactory = new DefaultSoapEngineFactory(),
        private readonly mixed $httpClientFactory = new DefaultHttpClientFactory(),
        private readonly mixed $httpRequestFactoryFactory = [Psr17FactoryDiscovery::class, 'findRequestFactory'],
    ) {
    }

    /**
     * @throws SdkError
     */
    public function getCertificateValidity(MerchantId $merchantId): CertificateValidity
    {
        try {
            $response = $this->soapClient()
                ->getCertificateValidity(new GetCertificateValidityRequestType((string) $merchantId, null));
            return new CertificateValidity(
                DateTimeImmutable::createFromInterface($response->getCertificateExpiryDate()),
                $response->getRenewalAllowed()
            );
        } catch (SoapException $e) {
            throw ApiFailure::fromThrowable($e);
        }
    }

    /**
     * @throws SdkError
     */
    public function renewCertificate(MerchantId $merchantId): CertificateRenewal
    {
        try {
            $response = $this->soapClient()
                ->renewCertificate(
                    new RenewCertificateRequestType(
                        (string) $merchantId,
                        MerchantAliasId: null,
                        CertificatePassword: $this->certificate->pkcs12()
                            ->passphrase()
                    )
                );

            $certificate = CertificateContainer::fromPkcs12(
                new Pkcs12Certificate(new InMemoryStream(non_empty_string()->assert(
                    $response->getMerchantCertificate()
                )), $this->certificate->pkcs12()
                    ->passphrase())
            );
            $this->setCertificate($certificate);

            return new CertificateRenewal(
                $certificate,
                DateTimeImmutable::createFromInterface($response->getExpirationDate())
            );
        } catch (SoapException $e) {
            throw ApiFailure::fromThrowable($e);
        }
    }

    private function setCertificate(CertificateContainer $container): void
    {
        $this->certificate = $container;
        $this->soapClient = null;
    }

    /**
     * @throws SdkError
     */
    public function startOrder(
        MerchantId $merchantId,
        Money $requestedAmount,
        OrderKind $orderKind,
        TransactionReference $transactionReference,
    ): Order {
        $this->enrollCashRegister($merchantId);

        try {
            $response = $this->soapClient()
                ->startOrder(
                    new StartOrderRequestType(
                        MerchantInformation: (new MerchantInformationType())
                            ->withMerchantUuid((string) $merchantId)
                            ->withCashRegisterId((string) $merchantId),
                        Order: (new OrderRequestType())
                            ->withRequestedAmount(
                                (new CurrencyAmountType())
                                    ->withAmount($requestedAmount->amount())
                                    ->withCurrency($requestedAmount->currency())
                            )
                            ->withMerchantTransactionReference((string) $transactionReference)
                            ->withType((string) $orderKind)
                            ->withPostingType(self::POSTING_TYPE_GOODS)
                            ->withConfirmationNeeded(true),
                        Coupons: null,
                        OfflineAuthorization: null,
                        CustomerRelationUuid: null,
                        PairingUuid: null,
                        UnidentifiedCustomer: true,
                        ExpressMerchantAuthorization: null,
                        QRCodeRendering: null,
                        PaymentLayerRendering: null,
                        OrderUpdateNotificationURL: null
                    )
                );

            return new Order(
                OrderId::fromString($response->getOrderUuid()),
                new OrderStatus($response->getOrderStatus()->getStatus()->get_()),
                new TransactionStatus($response->getOrderStatus()->getReason()->get_()),
                $transactionReference
            );
        } catch (SoapException $e) {
            throw ApiFailure::fromThrowable($e);
        }
    }

    /**
     * @throws SdkError
     */
    public function monitorOrderByOrderId(MerchantId $merchantId, OrderId $orderId): Order
    {
        $this->enrollCashRegister($merchantId);

        try {
            $response = $this->soapClient()
                ->monitorOrder(
                    new MonitorOrderRequestType(
                        MerchantInformation: (new MerchantInformationType())
                            ->withMerchantUuid((string) $merchantId)
                            ->withCashRegisterId((string) $merchantId),
                        OrderUuid: (string) $orderId,
                        MerchantTransactionReference: null,
                        WaitForResponse: false
                    )
                );

            return new Order(
                OrderId::fromString($response->getOrder()->getUuid()),
                new OrderStatus($response->getOrder()->getStatus()->getStatus()->get_()),
                new TransactionStatus($response->getOrder()->getStatus()->getReason()->get_()),
                new TransactionReference(non_empty_string()->assert(
                    $response->getOrder()
                        ->getMerchantTransactionReference()
                )),
            );
        } catch (SoapException $e) {
            throw ApiFailure::fromThrowable($e);
        }
    }

    /**
     * @throws SdkError
     */
    public function monitorOrderByTransactionReference(
        MerchantId $merchantId,
        TransactionReference $transactionReference
    ): Order {
        $this->enrollCashRegister($merchantId);

        try {
            $response = $this->soapClient()
                ->monitorOrder(
                    new MonitorOrderRequestType(
                        MerchantInformation: (new MerchantInformationType())
                            ->withMerchantUuid((string) $merchantId)
                            ->withCashRegisterId((string) $merchantId),
                        OrderUuid: null,
                        MerchantTransactionReference: (string) $transactionReference,
                        WaitForResponse: false
                    )
                );

            return new Order(
                OrderId::fromString($response->getOrder()->getUuid()),
                new OrderStatus($response->getOrder()->getStatus()->getStatus()->get_()),
                new TransactionStatus($response->getOrder()->getStatus()->getReason()->get_()),
                new TransactionReference(non_empty_string()->assert(
                    $response->getOrder()
                        ->getMerchantTransactionReference()
                )),
            );
        } catch (SoapException $e) {
            throw ApiFailure::fromThrowable($e);
        }
    }

    /**
     * @throws SdkError
     */
    public function confirmOrderByOrderId(MerchantId $merchantId, OrderId $orderId, Money $requestedAmount): Order
    {
        $this->enrollCashRegister($merchantId);

        try {
            $response = $this->soapClient()
                ->confirmOrder(
                    new ConfirmOrderRequestType(
                        MerchantInformation: (new MerchantInformationType())
                            ->withMerchantUuid((string) $merchantId)
                            ->withCashRegisterId((string) $merchantId),
                        OrderUuid: (string) $orderId,
                        MerchantTransactionReference: null,
                        RequestedAmount: (new CurrencyAmountType())
                            ->withAmount($requestedAmount->amount())
                            ->withCurrency($requestedAmount->currency()),
                        PartialConfirmation: false
                    )
                );

            return new Order(
                OrderId::fromString($response->getOrder()->getUuid()),
                new OrderStatus($response->getOrder()->getStatus()->getStatus()->get_()),
                new TransactionStatus($response->getOrder()->getStatus()->getReason()->get_()),
                new TransactionReference(non_empty_string()->assert(
                    $response->getOrder()
                        ->getMerchantTransactionReference()
                )),
            );
        } catch (SoapException $e) {
            throw ApiFailure::fromThrowable($e);
        }
    }

    /**
     * @throws SdkError
     */
    public function confirmOrderByTransactionReference(
        MerchantId $merchantId,
        TransactionReference $transactionReference,
        Money $requestedAmount
    ): Order {
        $this->enrollCashRegister($merchantId);

        try {
            $response = $this->soapClient()
                ->confirmOrder(
                    new ConfirmOrderRequestType(
                        MerchantInformation: (new MerchantInformationType())
                            ->withMerchantUuid((string) $merchantId)
                            ->withCashRegisterId((string) $merchantId),
                        OrderUuid: null,
                        MerchantTransactionReference: (string) $transactionReference,
                        RequestedAmount: (new CurrencyAmountType())
                            ->withAmount($requestedAmount->amount())
                            ->withCurrency($requestedAmount->currency()),
                        PartialConfirmation: false
                    )
                );

            return new Order(
                OrderId::fromString($response->getOrder()->getUuid()),
                new OrderStatus($response->getOrder()->getStatus()->getStatus()->get_()),
                new TransactionStatus($response->getOrder()->getStatus()->getReason()->get_()),
                new TransactionReference(non_empty_string()->assert(
                    $response->getOrder()
                        ->getMerchantTransactionReference()
                )),
            );
        } catch (SoapException $e) {
            throw ApiFailure::fromThrowable($e);
        }
    }

    /**
     * @phpstan-ignore-next-line
     * @throws SdkError
     */
    public function detectDevice(string $userAgent): DetectedDevice
    {
        return new DetectedDevice($userAgent, match (true) {
            str_contains($userAgent, 'iPhone') => DetectedDevice::IOS,
            str_contains($userAgent, 'iPad') => DetectedDevice::IOS,
            str_contains($userAgent, 'Android') => DetectedDevice::ANDROID,
            default => DetectedDevice::UNKNOWN,
        });
    }

    /**
     * @throws SdkError
     */
    public function getIosAppSchemes(): array
    {
        try {
            $response = $this->httpClient()
                ->sendRequest(
                    $this->httpRequestFactory()
                        ->createRequest('GET', (string) $this->environment->appSchemeUrl())
                );
        } catch (ClientExceptionInterface $e) {
            throw ApiFailure::fromThrowable($e);
        }

        invariant(
            $response->getStatusCode() === 200,
            'Failed to fetch iOS app schemes. Expected status code 200, got %d',
            $response->getStatusCode()
        );
        $contentType = $response->getHeader('content-type');
        invariant(count($contentType) === 1, 'Expected single content type header');
        invariant(
            vec(string())
                ->assert($contentType)[0] === 'application/json',
            'Invalid content type. Expected "%s", got "%s"',
            'application/json',
            $contentType[0]
        );

        try {
            $parsed = json_decode($response->getBody()->getContents(), true, flags: JSON_THROW_ON_ERROR);
        } catch (Throwable $e) {
            throw ApiFailure::fromThrowable($e);
        }

        return array_map(
            static fn (array $config) => new IosAppScheme(
                non_empty_string()
                    ->assert($config['issuerUrlScheme']),
                non_empty_string()
                    ->assert($config['displayName'])
            ),
            shape([
                'appSwitchConfigList' => vec(
                    shape([
                        'issuerUrlScheme' => non_empty_string(),
                        'displayName' => non_empty_string(),
                    ], true)
                ),
            ], true)->assert($parsed)['appSwitchConfigList']
        );
    }

    /**
     * @throws SdkError
     */
    private function enrollCashRegister(MerchantId $merchantId): void
    {
        if (in_array((string) $merchantId, self::$enrolledCacheRegisters, true)) {
            return;
        }

        try {
            $this->soapClient()
                ->enrollCashRegister(
                    new EnrollCashRegisterRequestType(
                        MerchantInformation: (new MerchantInformationType())
                            ->withMerchantUuid((string) $merchantId)
                            ->withCashRegisterId((string) $merchantId),
                        CashRegisterType: self::CASH_REGISTER_TYPE_EPOS,
                        FormerCashRegisterId: null,
                        BeaconInventoryNumber: null,
                        BeaconDaemonVersion: null
                    )
                );

            self::$enrolledCacheRegisters[] = (string) $merchantId;
        } catch (SoapException $e) {
            throw ApiFailure::fromThrowable($e);
        }
    }

    private function soapClient(): TwintSoapClient
    {
        return $this->soapClient ??= new TwintSoapClient(
            new EngineCaller(
                ($this->soapEngineFactory)($this->fileWriter, $this->certificate, $this->version, $this->environment)
            )
        );
    }

    private function httpClient(): ClientInterface
    {
        return $this->httpClient ??= ($this->httpClientFactory)($this->fileWriter, $this->certificate);
    }

    private function httpRequestFactory(): RequestFactoryInterface
    {
        return $this->httpRequestFactory ??= ($this->httpRequestFactoryFactory)();
    }
}
