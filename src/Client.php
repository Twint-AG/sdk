<?php

declare(strict_types=1);

namespace Twint\Sdk;

use Http\Discovery\Psr17FactoryDiscovery;
use Override;
use Phpro\SoapClient\Caller\EngineCaller;
use Phpro\SoapClient\Exception\SoapException;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Soap\Engine\Engine;
use Throwable;
use Twint\Sdk\Capability\DeviceHandling;
use Twint\Sdk\Capability\OrderAdministration;
use Twint\Sdk\Capability\OrderCheckout;
use Twint\Sdk\Capability\OrderMonitoring;
use Twint\Sdk\Capability\OrderReversal;
use Twint\Sdk\Capability\SystemAdministration;
use Twint\Sdk\Certificate\CertificateContainer;
use Twint\Sdk\Exception\ApiFailure;
use Twint\Sdk\Exception\SdkError;
use Twint\Sdk\Factory\DefaultHttpClientFactory;
use Twint\Sdk\Factory\DefaultSoapEngineFactory;
use Twint\Sdk\Generated\TwintSoapClient;
use Twint\Sdk\Generated\Type\CancelOrderRequestElement;
use Twint\Sdk\Generated\Type\CheckSystemStatusRequestElement;
use Twint\Sdk\Generated\Type\ConfirmOrderRequestElement;
use Twint\Sdk\Generated\Type\CurrencyAmountType;
use Twint\Sdk\Generated\Type\EnrollCashRegisterRequestElement;
use Twint\Sdk\Generated\Type\MerchantInformationType;
use Twint\Sdk\Generated\Type\MonitorOrderRequestElement;
use Twint\Sdk\Generated\Type\OrderLinkType;
use Twint\Sdk\Generated\Type\OrderRequestType;
use Twint\Sdk\Generated\Type\StartOrderRequestElement;
use Twint\Sdk\Io\FileWriter;
use Twint\Sdk\Io\TemporaryFileWriter;
use Twint\Sdk\Value\DetectedDevice;
use Twint\Sdk\Value\Environment;
use Twint\Sdk\Value\FiledMerchantTransactionReference;
use Twint\Sdk\Value\IosAppScheme;
use Twint\Sdk\Value\MerchantId;
use Twint\Sdk\Value\MerchantTransactionReference;
use Twint\Sdk\Value\Money;
use Twint\Sdk\Value\Order;
use Twint\Sdk\Value\OrderId;
use Twint\Sdk\Value\OrderStatus;
use Twint\Sdk\Value\PairingStatus;
use Twint\Sdk\Value\PairingToken;
use Twint\Sdk\Value\QrCode;
use Twint\Sdk\Value\SystemStatus;
use Twint\Sdk\Value\TransactionStatus;
use Twint\Sdk\Value\UnfiledMerchantTransactionReference;
use Twint\Sdk\Value\Version;
use function Psl\invariant;
use function Psl\Type\non_empty_string;
use function Psl\Type\shape;
use function Psl\Type\string;
use function Psl\Type\uint;
use function Psl\Type\vec;

final class Client implements DeviceHandling, OrderAdministration, OrderCheckout, OrderMonitoring, OrderReversal, SystemAdministration
{
    private const POSTING_TYPE_GOODS = 'GOODS';

    private const CASH_REGISTER_TYPE_EPOS = 'EPOS';

    private const ORDER_KIND_PAYMENT_IMMEDIATE = 'PAYMENT_IMMEDIATE';

    private const ORDER_KIND_REVERSAL = 'REVERSAL';

    private readonly ?TwintSoapClient $soapClient;

    private readonly ?ClientInterface $httpClient;

    private readonly ?RequestFactoryInterface $httpRequestFactory;

    /**
     * @var list<string>
     */
    private static array $enrolledCacheRegisters = [];

    /**
     * @param callable(FileWriter, CertificateContainer, Version, Environment): Engine $soapEngineFactory
     * @param callable(FileWriter, CertificateContainer): ClientInterface $httpClientFactory
     * @param callable(): RequestFactoryInterface $httpRequestFactoryFactory
     */
    public function __construct(
        private readonly CertificateContainer $certificate,
        private readonly MerchantId $merchantId,
        private readonly Version $version,
        private readonly Environment $environment,
        private readonly FileWriter $fileWriter = new TemporaryFileWriter(),
        private readonly mixed $soapEngineFactory = new DefaultSoapEngineFactory(),
        private readonly mixed $httpClientFactory = new DefaultHttpClientFactory(),
        private readonly mixed $httpRequestFactoryFactory = [Psr17FactoryDiscovery::class, 'findRequestFactory'],
    ) {
    }

    /**
     * @throws SdkError
     */
    #[Override]
    public function checkSystemStatus(): SystemStatus
    {
        try {
            $response = $this->soapClient()
                ->checkSystemStatus(
                    new CheckSystemStatusRequestElement(
                        (new MerchantInformationType())
                            ->withMerchantUuid((string) $this->merchantId)
                            ->withCashRegisterId('')
                    )
                );

            return new SystemStatus($response->getStatus());
        } catch (SoapException $e) {
            throw ApiFailure::fromThrowable($e);
        }
    }

    /**
     * @throws SdkError
     */
    #[Override]
    public function startOrder(
        UnfiledMerchantTransactionReference $orderReference,
        Money $requestedAmount,
    ): Order {
        $this->enrollCashRegister();

        try {
            $response = $this->soapClient()
                ->startOrder(
                    new StartOrderRequestElement(
                        MerchantInformation: (new MerchantInformationType())
                            ->withMerchantUuid((string) $this->merchantId)
                            ->withCashRegisterId((string) $this->merchantId),
                        Order: (new OrderRequestType())
                            ->withRequestedAmount(
                                (new CurrencyAmountType())
                                    ->withAmount($requestedAmount->amount())
                                    ->withCurrency($requestedAmount->currency())
                            )
                            ->withMerchantTransactionReference((string) $orderReference)
                            ->withType(self::ORDER_KIND_PAYMENT_IMMEDIATE)
                            ->withPostingType(self::POSTING_TYPE_GOODS)
                            ->withConfirmationNeeded(true),
                        Coupons: null,
                        OfflineAuthorization: null,
                        CustomerRelationUuid: null,
                        PairingUuid: null,
                        UnidentifiedCustomer: true,
                        ExpressMerchantAuthorization: null,
                        QRCodeRendering: true,
                        PaymentLayerRendering: null,
                        OrderUpdateNotificationURL: null
                    )
                );

            return new Order(
                OrderId::fromString($response->getOrderUuid()),
                new FiledMerchantTransactionReference((string) $orderReference),
                OrderStatus::fromString($response->getOrderStatus()->getStatus()->get_()),
                TransactionStatus::fromString($response->getOrderStatus()->getReason()->get_()),
                PairingStatus::fromString($response->getPairingStatus()),
                new PairingToken(uint()->assert($response->getToken())),
                new QrCode(non_empty_string()->assert($response->getQRCode()))
            );
        } catch (SoapException $e) {
            throw ApiFailure::fromThrowable($e);
        }
    }

    /**
     * @throws SdkError
     */
    #[Override]
    public function monitorOrder(OrderId|FiledMerchantTransactionReference $orderIdOrRef): Order
    {
        $this->enrollCashRegister();

        try {
            $response = $this->soapClient()
                ->monitorOrder(
                    new MonitorOrderRequestElement(
                        MerchantInformation: (new MerchantInformationType())
                            ->withMerchantUuid((string) $this->merchantId)
                            ->withCashRegisterId((string) $this->merchantId),
                        OrderUuid: $orderIdOrRef instanceof OrderId ? (string) $orderIdOrRef : null,
                        MerchantTransactionReference: $orderIdOrRef instanceof MerchantTransactionReference ? (string) $orderIdOrRef : null,
                        WaitForResponse: false
                    )
                );

            return new Order(
                OrderId::fromString($response->getOrder()->getUuid()),
                new FiledMerchantTransactionReference(
                    non_empty_string()
                        ->assert($response->getOrder()->getMerchantTransactionReference())
                ),
                OrderStatus::fromString($response->getOrder()->getStatus()->getStatus()->get_()),
                TransactionStatus::fromString($response->getOrder()->getStatus()->getReason()->get_()),
                PairingStatus::fromString($response->getPairingStatus()),
            );
        } catch (SoapException $e) {
            throw ApiFailure::fromThrowable($e);
        }
    }

    /**
     * @throws SdkError
     */
    #[Override]
    public function cancelOrder(OrderId|FiledMerchantTransactionReference $orderIdOrRef): Order
    {
        $this->enrollCashRegister();

        try {
            $response = $this->soapClient()
                ->cancelOrder(
                    new CancelOrderRequestElement(
                        MerchantInformation: (new MerchantInformationType())
                            ->withMerchantUuid((string) $this->merchantId)
                            ->withCashRegisterId((string) $this->merchantId),
                        OrderUuid: $orderIdOrRef instanceof OrderId ? (string) $orderIdOrRef : null,
                        MerchantTransactionReference: $orderIdOrRef instanceof MerchantTransactionReference ? (string) $orderIdOrRef : null
                    )
                );

            return new Order(
                OrderId::fromString($response->getOrder()->getUuid()),
                new FiledMerchantTransactionReference(
                    non_empty_string()
                        ->assert($response->getOrder()->getMerchantTransactionReference())
                ),
                OrderStatus::fromString($response->getOrder()->getStatus()->getStatus()->get_()),
                TransactionStatus::fromString($response->getOrder()->getStatus()->getReason()->get_()),
            );
        } catch (SoapException $e) {
            throw ApiFailure::fromThrowable($e);
        }
    }

    /**
     * @throws SdkError
     */
    #[Override]
    public function confirmOrder(
        OrderId|FiledMerchantTransactionReference $orderIdOrRef,
        Money $requestedAmount
    ): Order {
        $this->enrollCashRegister();

        try {
            $response = $this->soapClient()
                ->confirmOrder(
                    new ConfirmOrderRequestElement(
                        MerchantInformation: (new MerchantInformationType())
                            ->withMerchantUuid((string) $this->merchantId)
                            ->withCashRegisterId((string) $this->merchantId),
                        OrderUuid: $orderIdOrRef instanceof OrderId ? (string) $orderIdOrRef : null,
                        MerchantTransactionReference: $orderIdOrRef instanceof MerchantTransactionReference ? (string) $orderIdOrRef : null,
                        RequestedAmount: (new CurrencyAmountType())
                            ->withAmount($requestedAmount->amount())
                            ->withCurrency($requestedAmount->currency()),
                        PartialConfirmation: false
                    )
                );

            return new Order(
                OrderId::fromString($response->getOrder()->getUuid()),
                new FiledMerchantTransactionReference(
                    non_empty_string()
                        ->assert($response->getOrder()->getMerchantTransactionReference())
                ),
                OrderStatus::fromString($response->getOrder()->getStatus()->getStatus()->get_()),
                TransactionStatus::fromString($response->getOrder()->getStatus()->getReason()->get_()),
            );
        } catch (SoapException $e) {
            throw ApiFailure::fromThrowable($e);
        }
    }

    /**
     * @throws SdkError
     */
    #[Override]
    public function reverseOrder(
        UnfiledMerchantTransactionReference $reversalReference,
        OrderId|FiledMerchantTransactionReference $orderIdOrRef,
        Money $reversalAmount
    ): Order {
        $this->enrollCashRegister();

        try {
            $response = $this->soapClient()
                ->startOrder(
                    new StartOrderRequestElement(
                        MerchantInformation: (new MerchantInformationType())
                            ->withMerchantUuid((string) $this->merchantId)
                            ->withCashRegisterId((string) $this->merchantId),
                        Order: (new OrderRequestType())
                            ->withRequestedAmount(
                                (new CurrencyAmountType())
                                    ->withAmount($reversalAmount->amount())
                                    ->withCurrency($reversalAmount->currency())
                            )
                            ->withMerchantTransactionReference((string) $reversalReference)
                            ->withLink(
                                (new OrderLinkType())
                                    ->withMerchantTransactionReference(
                                        $orderIdOrRef instanceof MerchantTransactionReference ? (string) $orderIdOrRef : null
                                    )
                                    ->withOrderUuid($orderIdOrRef instanceof OrderId ? (string) $orderIdOrRef : null)
                            )
                            ->withType(self::ORDER_KIND_REVERSAL)
                            ->withPostingType(self::POSTING_TYPE_GOODS)
                            ->withConfirmationNeeded(false),
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
                new FiledMerchantTransactionReference((string) $reversalReference),
                OrderStatus::fromString($response->getOrderStatus()->getStatus()->get_()),
                TransactionStatus::fromString($response->getOrderStatus()->getReason()->get_())
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
    #[Override]
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
    private function enrollCashRegister(): void
    {
        if (in_array((string) $this->merchantId, self::$enrolledCacheRegisters, true)) {
            return;
        }

        try {
            $this->soapClient()
                ->enrollCashRegister(
                    new EnrollCashRegisterRequestElement(
                        MerchantInformation: (new MerchantInformationType())
                            ->withMerchantUuid((string) $this->merchantId)
                            ->withCashRegisterId((string) $this->merchantId),
                        CashRegisterType: self::CASH_REGISTER_TYPE_EPOS,
                        FormerCashRegisterId: null,
                        BeaconInventoryNumber: null,
                        BeaconDaemonVersion: null
                    )
                );

            self::$enrolledCacheRegisters[] = (string) $this->merchantId;
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
