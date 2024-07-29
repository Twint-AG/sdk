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
use Twint\Sdk\Capability\CoreCapabilities;
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
use Twint\Sdk\Generated\Type\MonitorFastCheckoutCheckInRequestElement;
use Twint\Sdk\Generated\Type\MonitorOrderRequestElement;
use Twint\Sdk\Generated\Type\OrderLinkType;
use Twint\Sdk\Generated\Type\OrderRequestType;
use Twint\Sdk\Generated\Type\RequestFastCheckoutCheckInRequestElement;
use Twint\Sdk\Generated\Type\ShippingMethodReferenceType;
use Twint\Sdk\Generated\Type\StartOrderRequestElement;
use Twint\Sdk\Io\FileWriter;
use Twint\Sdk\Io\TemporaryFileWriter;
use Twint\Sdk\Value\Address;
use Twint\Sdk\Value\AlphanumericPairingToken;
use Twint\Sdk\Value\CashRegisterId;
use Twint\Sdk\Value\CustomerData;
use Twint\Sdk\Value\CustomerDataScopes;
use Twint\Sdk\Value\Date;
use Twint\Sdk\Value\DetectedDevice;
use Twint\Sdk\Value\Email;
use Twint\Sdk\Value\Environment;
use Twint\Sdk\Value\FastCheckoutCheckIn;
use Twint\Sdk\Value\FiledMerchantTransactionReference;
use Twint\Sdk\Value\InteractiveFastCheckoutCheckIn;
use Twint\Sdk\Value\IosAppScheme;
use Twint\Sdk\Value\MerchantInformation;
use Twint\Sdk\Value\Money;
use Twint\Sdk\Value\NumericPairingToken;
use Twint\Sdk\Value\Order;
use Twint\Sdk\Value\OrderId;
use Twint\Sdk\Value\OrderReference;
use Twint\Sdk\Value\OrderStatus;
use Twint\Sdk\Value\PairingStatus;
use Twint\Sdk\Value\PairingUuid;
use Twint\Sdk\Value\PhoneNumber;
use Twint\Sdk\Value\PrefixedCashRegisterId;
use Twint\Sdk\Value\QrCode;
use Twint\Sdk\Value\ShippingMethod;
use Twint\Sdk\Value\ShippingMethodId;
use Twint\Sdk\Value\ShippingMethods;
use Twint\Sdk\Value\StoreUuid;
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

final class Client implements CoreCapabilities
{
    private const POSTING_TYPE_GOODS = 'GOODS';

    private const CASH_REGISTER_TYPE_EPOS = 'EPOS';

    private const ORDER_KIND_PAYMENT_IMMEDIATE = 'PAYMENT_IMMEDIATE';

    private const ORDER_KIND_REVERSAL = 'REVERSAL';

    private readonly StoreUuid $storeUuid;

    private readonly CashRegisterId $cashRegisterId;

    private readonly ?TwintSoapClient $soapClient;

    private readonly ?ClientInterface $httpClient;

    private readonly ?RequestFactoryInterface $httpRequestFactory;

    /**
     * @var list<string>
     */
    private static array $enrolledCashRegisters = [];

    /**
     * @param callable(FileWriter, CertificateContainer, Version, Environment): Engine $soapEngineFactory
     * @param callable(FileWriter, CertificateContainer): ClientInterface $httpClientFactory
     * @param callable(): RequestFactoryInterface $httpRequestFactoryFactory
     */
    public function __construct(
        private readonly CertificateContainer $certificate,
        MerchantInformation $merchantInformation,
        private readonly Version $version,
        private readonly Environment $environment,
        private readonly FileWriter $fileWriter = new TemporaryFileWriter(),
        private readonly mixed $soapEngineFactory = new DefaultSoapEngineFactory(),
        private readonly mixed $httpClientFactory = new DefaultHttpClientFactory(),
        private readonly mixed $httpRequestFactoryFactory = [Psr17FactoryDiscovery::class, 'findRequestFactory'],
    ) {
        $this->storeUuid = $merchantInformation->storeUuid();
        $this->cashRegisterId = $merchantInformation->cashRegisterId()
            ?? PrefixedCashRegisterId::unknown($this->storeUuid);
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
                            ->withMerchantUuid((string) $this->storeUuid)
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
    public function startOrder(UnfiledMerchantTransactionReference $orderReference, Money $requestedAmount): Order
    {
        $this->enrollCashRegister();

        try {
            $response = $this->soapClient()
                ->startOrder(
                    new StartOrderRequestElement(
                        MerchantInformation: (new MerchantInformationType())
                            ->withMerchantUuid((string) $this->storeUuid)
                            ->withCashRegisterId((string) $this->cashRegisterId),
                        Order: (new OrderRequestType())
                            ->withRequestedAmount(
                                (new CurrencyAmountType())
                                    ->withAmount($requestedAmount->amount())
                                    ->withCurrency($requestedAmount->currency())
                            )
                            ->withMerchantTransactionReference((string) $orderReference)
                            ->withType(self::ORDER_KIND_PAYMENT_IMMEDIATE)
                            ->withPostingType(self::POSTING_TYPE_GOODS)
                            ->withConfirmationNeeded(false),
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
                $requestedAmount,
                PairingStatus::fromString($response->getPairingStatus()),
                new NumericPairingToken(uint()->assert($response->getToken())),
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
    public function monitorOrder(OrderReference $orderReference): Order
    {
        $this->enrollCashRegister();

        try {
            $response = $this->soapClient()
                ->monitorOrder(
                    new MonitorOrderRequestElement(
                        MerchantInformation: (new MerchantInformationType())
                            ->withMerchantUuid((string) $this->storeUuid)
                            ->withCashRegisterId((string) $this->cashRegisterId),
                        OrderUuid: $orderReference->asOrderUuidString(),
                        MerchantTransactionReference: $orderReference->asMerchantTransactionReferenceString(),
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
                new Money(
                    $response->getOrder()
                        ->getRequestedAmount()
                        ->getCurrency(),
                    $response->getOrder()
                        ->getRequestedAmount()
                        ->getAmount()
                ),
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
    public function cancelOrder(OrderReference $orderReference): Order
    {
        $this->enrollCashRegister();

        try {
            $response = $this->soapClient()
                ->cancelOrder(
                    new CancelOrderRequestElement(
                        MerchantInformation: (new MerchantInformationType())
                            ->withMerchantUuid((string) $this->storeUuid)
                            ->withCashRegisterId((string) $this->cashRegisterId),
                        OrderUuid: $orderReference->asOrderUuidString(),
                        MerchantTransactionReference: $orderReference->asMerchantTransactionReferenceString(),
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
                new Money(
                    $response->getOrder()
                        ->getRequestedAmount()
                        ->getCurrency(),
                    $response->getOrder()
                        ->getRequestedAmount()
                        ->getAmount()
                ),
            );
        } catch (SoapException $e) {
            throw ApiFailure::fromThrowable($e);
        }
    }

    /**
     * @throws SdkError
     */
    #[Override]
    public function confirmOrder(OrderReference $orderReference, Money $requestedAmount): Order
    {
        $this->enrollCashRegister();

        try {
            $response = $this->soapClient()
                ->confirmOrder(
                    new ConfirmOrderRequestElement(
                        MerchantInformation: (new MerchantInformationType())
                            ->withMerchantUuid((string) $this->storeUuid)
                            ->withCashRegisterId((string) $this->cashRegisterId),
                        OrderUuid: $orderReference->asOrderUuidString(),
                        MerchantTransactionReference: $orderReference->asMerchantTransactionReferenceString(),
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
                new Money(
                    $response->getOrder()
                        ->getRequestedAmount()
                        ->getCurrency(),
                    $response->getOrder()
                        ->getRequestedAmount()
                        ->getAmount()
                ),
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
        OrderReference $orderReference,
        Money $reversalAmount
    ): Order {
        $this->enrollCashRegister();

        try {
            $response = $this->soapClient()
                ->startOrder(
                    new StartOrderRequestElement(
                        MerchantInformation: (new MerchantInformationType())
                            ->withMerchantUuid((string) $this->storeUuid)
                            ->withCashRegisterId((string) $this->cashRegisterId),
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
                                        $orderReference->asMerchantTransactionReferenceString()
                                    )
                                    ->withOrderUuid($orderReference->asOrderUuidString())
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
                TransactionStatus::fromString($response->getOrderStatus()->getReason()->get_()),
                $reversalAmount
            );
        } catch (SoapException $e) {
            throw ApiFailure::fromThrowable($e);
        }
    }

    /**
     * @throws SdkError
     */
    #[Override]
    public function requestFastCheckoutCheckIn(
        Money $amountWithoutShipping,
        CustomerDataScopes $scopes,
        ShippingMethods $shippingMethods
    ): InteractiveFastCheckoutCheckIn {
        $this->enrollCashRegister();

        try {
            $response = $this->soapClient()
                ->requestFastCheckoutCheckIn(
                    new RequestFastCheckoutCheckInRequestElement(
                        MerchantInformation: (new MerchantInformationType())
                            ->withMerchantUuid((string) $this->storeUuid)
                            ->withCashRegisterId((string) $this->cashRegisterId),
                        NetAmount: (new CurrencyAmountType())
                            ->withAmount($amountWithoutShipping->amount())
                            ->withCurrency($amountWithoutShipping->currency()),
                        // @phpstan-ignore-next-line
                        RequestedScopes: $scopes->toList(),
                        // @phpstan-ignore-next-line
                        ShippingMethods: array_map(
                            static fn (ShippingMethod $method) => (new ShippingMethodReferenceType())
                                ->withShippingMethodId((string) $method->id())
                                ->withShippingMethodLabel($method->label())
                                ->withShippingMethodAmount(
                                    (new CurrencyAmountType())
                                        ->withAmount($method->price()->amount())
                                        ->withCurrency($method->price()->currency())
                                ),
                            iterator_to_array($shippingMethods)
                        ),
                        QRCodeRendering: true,
                    )
                );

            return new InteractiveFastCheckoutCheckIn(
                PairingUuid::fromString(
                    non_empty_string()
                        ->assert($response->getCheckInNotification()->getPairingUuid())
                ),
                PairingStatus::fromString($response->getCheckInNotification()->getPairingStatus()),
                AlphanumericPairingToken::fromString($response->getToken()->getDisplayToken()),
                new QrCode(non_empty_string()->assert($response->getQRCode())),
            );
        } catch (SoapException $e) {
            throw ApiFailure::fromThrowable($e);
        }
    }

    /**
     * @throws SdkError
     */
    #[Override]
    public function monitorFastCheckoutCheckIn(PairingUuid $pairingUuid): FastCheckoutCheckIn
    {
        try {
            $response = $this->soapClient()
                ->monitorFastCheckoutCheckIn(
                    new MonitorFastCheckoutCheckInRequestElement(
                        MerchantInformation: (new MerchantInformationType())
                            ->withMerchantUuid((string) $this->storeUuid)
                            ->withCashRegisterId((string) $this->cashRegisterId),
                        PairingUuid: (string) $pairingUuid,
                        WaitForResponse: false
                    )
                );

            $customerData = null;
            if ($response->getCustomerData() !== null) {
                $data = [];
                foreach ($response->getCustomerData()->getField() as $field) {
                    $key = $field->getName();
                    $data[$key] = match ($key) {
                        CustomerDataScopes::DATE_OF_BIRTH => Date::parse($field->getValue()),
                        CustomerDataScopes::EMAIL => new Email($field->getValue()),
                        CustomerDataScopes::PHONE_NUMBER => new PhoneNumber($field->getValue()),
                        CustomerDataScopes::SHIPPING_ADDRESS => Address::parse($field->getValue()),
                        default => null,
                    };
                }

                $customerData = CustomerData::fromDict($data);
            }

            return new FastCheckoutCheckIn(
                $pairingUuid,
                PairingStatus::fromString($response->getCheckInNotification()->getPairingStatus()),
                $response->getShippingMethodId() !== null
                    ? new ShippingMethodId($response->getShippingMethodId())
                    : null,
                $customerData
            );
        } catch (SoapException $e) {
            throw ApiFailure::fromThrowable($e);
        }
    }

    /**
     * @throws SdkError
     */
    #[Override]
    public function startFastCheckoutOrder(
        PairingUuid $pairingUuid,
        UnfiledMerchantTransactionReference $orderReference,
        Money $requestedAmount
    ): Order {
        $this->enrollCashRegister();

        try {
            $response = $this->soapClient()
                ->startOrder(
                    new StartOrderRequestElement(
                        MerchantInformation: (new MerchantInformationType())
                            ->withMerchantUuid((string) $this->storeUuid)
                            ->withCashRegisterId((string) $this->cashRegisterId),
                        Order: (new OrderRequestType())
                            ->withRequestedAmount(
                                (new CurrencyAmountType())
                                    ->withAmount($requestedAmount->amount())
                                    ->withCurrency($requestedAmount->currency())
                            )
                            ->withMerchantTransactionReference((string) $orderReference)
                            ->withType(self::ORDER_KIND_PAYMENT_IMMEDIATE)
                            ->withPostingType(self::POSTING_TYPE_GOODS)
                            ->withConfirmationNeeded(false),
                        Coupons: null,
                        OfflineAuthorization: null,
                        CustomerRelationUuid: null,
                        PairingUuid: (string) $pairingUuid,
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
                $requestedAmount,
                PairingStatus::fromString($response->getPairingStatus()),
                null,
                null
            );
        } catch (SoapException $e) {
            throw ApiFailure::fromThrowable($e);
        }
    }

    /**
     * @throws SdkError
     * @phpstan-ignore-next-line
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
        $cashRegisterId = (string) $this->cashRegisterId;

        if (in_array($cashRegisterId, self::$enrolledCashRegisters, true)) {
            return;
        }

        try {
            $this->soapClient()
                ->enrollCashRegister(
                    new EnrollCashRegisterRequestElement(
                        MerchantInformation: (new MerchantInformationType())
                            ->withMerchantUuid((string) $this->storeUuid)
                            ->withCashRegisterId($cashRegisterId),
                        CashRegisterType: self::CASH_REGISTER_TYPE_EPOS,
                        FormerCashRegisterId: null,
                        BeaconInventoryNumber: null,
                        BeaconDaemonVersion: null
                    )
                );

            self::$enrolledCashRegisters[] = $cashRegisterId;
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
