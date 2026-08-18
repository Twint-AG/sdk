<?php

declare(strict_types=1);

namespace Twint\Sdk;

use Http\Discovery\Psr17FactoryDiscovery;
use JsonException;
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
use Twint\Sdk\Exception\CancellationFailed;
use Twint\Sdk\Exception\InvalidValue;
use Twint\Sdk\Exception\SdkError;
use Twint\Sdk\Factory\DefaultHttpClientFactory;
use Twint\Sdk\Factory\DefaultSoapEngineFactory;
use Twint\Sdk\Generated\TwintSoapClient;
use Twint\Sdk\Generated\Type\CancelCheckInRequestElement;
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
use Twint\Sdk\Io\TemporaryFileWriterGuesser;
use Twint\Sdk\Soap\ErrorClassifier;
use Twint\Sdk\Soap\ExtSoapErrorClassifier;
use Twint\Sdk\Value\Address;
use Twint\Sdk\Value\AlphanumericPairingToken;
use Twint\Sdk\Value\CashRegisterId;
use Twint\Sdk\Value\Currency;
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
use Twint\Sdk\Value\PairingToken;
use Twint\Sdk\Value\PairingUuid;
use Twint\Sdk\Value\PaymentUrl;
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
use Twint\Sdk\Value\Url;
use Twint\Sdk\Value\Version;
use TypeError;
use ValueError;
use function Psl\invariant;
use function Psl\Type\instance_of;
use function Psl\Type\non_empty_string;
use function Psl\Type\non_empty_vec;
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

    private const CANCELLATION_REASON_PAYMENT_ABORT = 'PAYMENT_ABORT';

    private const CANCELLATION_STATUS_OK = 'OK';

    private readonly StoreUuid $storeUuid;

    private readonly CashRegisterId $cashRegisterId;

    private readonly TwintSoapClient $soapClient;

    private readonly ClientInterface $httpClient;

    private readonly RequestFactoryInterface $httpRequestFactory;

    private readonly FileWriter $fileWriter;

    /**
     * @var array<string, string[]>
     */
    private static array $enrolledCashRegisters = [];

    /**
     * @param (callable(): FileWriter)|FileWriter $fileWriter
     * @param callable(FileWriter, CertificateContainer, Version, Environment): Engine $soapEngineFactory
     * @param callable(FileWriter): ClientInterface $httpClientFactory
     * @param callable(): RequestFactoryInterface $httpRequestFactoryFactory
     */
    public function __construct(
        private readonly CertificateContainer $certificate,
        MerchantInformation $merchantInformation,
        private readonly Version $version,
        private readonly Environment $environment,
        FileWriter|callable $fileWriter = new TemporaryFileWriterGuesser(),
        private readonly mixed $soapEngineFactory = new DefaultSoapEngineFactory(),
        private readonly mixed $httpClientFactory = new DefaultHttpClientFactory(),
        private readonly mixed $httpRequestFactoryFactory = [Psr17FactoryDiscovery::class, 'findRequestFactory'],
        private readonly ErrorClassifier $errorClassifier = new ExtSoapErrorClassifier(),
    ) {
        $this->storeUuid = $merchantInformation->storeUuid();
        $this->cashRegisterId = $merchantInformation->cashRegisterId()
            ?? PrefixedCashRegisterId::unknown($this->storeUuid);
        $this->fileWriter = is_callable($fileWriter)
            ? instance_of(FileWriter::class)->assert($fileWriter())
            : $fileWriter;
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

            return SystemStatus::from($response->getStatus());
        } catch (SoapException | ValueError | TypeError $e) {
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

        return $this->doStartOrder($orderReference, $requestedAmount, 'custom');
    }

    /**
     * @throws SdkError
     */
    #[Override]
    public function startHostedOrder(UnfiledMerchantTransactionReference $orderReference, Money $requestedAmount): Order
    {
        $this->enrollCashRegister();

        return $this->doStartOrder($orderReference, $requestedAmount, 'hosted');
    }

    /**
     * @param 'custom'|'hosted' $uiType
     * @throws SdkError
     * @return ($uiType is 'custom' ? Order<PairingStatus::*, NumericPairingToken, QrCode, null> : Order<PairingStatus::*, NumericPairingToken, null, PaymentUrl>)
     */
    private function doStartOrder(
        UnfiledMerchantTransactionReference $orderReference,
        Money $requestedAmount,
        string $uiType
    ): Order {
        try {
            $response = $this->soapClient()
                ->startOrder(
                    new StartOrderRequestElement(
                        MerchantInformation: (new MerchantInformationType())
                            ->withMerchantUuid((string) $this->storeUuid)
                            ->withCashRegisterId((string) $this->cashRegisterId),
                        OperationOrigin: null,
                        Order: (new OrderRequestType())
                            ->withRequestedAmount(
                                (new CurrencyAmountType())
                                    ->withAmount($requestedAmount->amount())
                                    ->withCurrency($requestedAmount->currency()->value)
                            )
                            ->withMerchantTransactionReference((string) $orderReference)
                            ->withType(self::ORDER_KIND_PAYMENT_IMMEDIATE)
                            ->withPostingType(self::POSTING_TYPE_GOODS)
                            ->withConfirmationNeeded(true),
                        Coupons: null,
                        CustomerRelationUuid: null,
                        PairingUuid: null,
                        UnidentifiedCustomer: true,
                        ExpressMerchantAuthorization: null,
                        QRCodeRendering: $uiType === 'custom' ? true : null,
                        PaymentLayerRendering: $uiType === 'hosted' ? 'PAYMENT_PAGE' : null,
                        OrderUpdateNotificationURL: null
                    )
                );

            $orderId = OrderId::fromString($response->getOrderUuid());
            $filedMerchantTransactionReference = new FiledMerchantTransactionReference((string) $orderReference);
            $orderStatus = OrderStatus::from($response->getOrderStatus()->getStatus()->get_());
            $transactionStatus = TransactionStatus::from($response->getOrderStatus()->getReason()->get_());
            $pairingStatus = PairingStatus::from($response->getPairingStatus());
            $pairingToken = new NumericPairingToken(uint()->assert($response->getToken()));

            if ($uiType === 'custom') {
                return new Order(
                    $orderId,
                    $filedMerchantTransactionReference,
                    $orderStatus,
                    $transactionStatus,
                    $requestedAmount,
                    $pairingStatus,
                    $pairingToken,
                    new QrCode(non_empty_string()->assert($response->getQRCode()))
                );
            }

            return new Order(
                $orderId,
                $filedMerchantTransactionReference,
                $orderStatus,
                $transactionStatus,
                $requestedAmount,
                $pairingStatus,
                $pairingToken,
                null,
                new PaymentUrl(new Url(non_empty_string()->assert($response->getTwintURL())))
            );
        } catch (SoapException | ValueError | TypeError $e) {
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
                OrderStatus::from($response->getOrder()->getStatus()->getStatus()->get_()),
                TransactionStatus::from($response->getOrder()->getStatus()->getReason()->get_()),
                new Money(
                    Currency::from($response->getOrder()->getRequestedAmount()->getCurrency()),
                    $response->getOrder()
                        ->getRequestedAmount()
                        ->getAmount()
                ),
                PairingStatus::from($response->getPairingStatus()),
            );
        } catch (SoapException | ValueError | TypeError $e) {
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
                        OperationOrigin: null,
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
                OrderStatus::from($response->getOrder()->getStatus()->getStatus()->get_()),
                TransactionStatus::from($response->getOrder()->getStatus()->getReason()->get_()),
                new Money(
                    Currency::from($response->getOrder()->getRequestedAmount()->getCurrency()),
                    $response->getOrder()
                        ->getRequestedAmount()
                        ->getAmount()
                ),
            );
        } catch (SoapException | ValueError | TypeError $e) {
            if ($this->errorClassifier->isOfType($e, ErrorClassifier::STATUS_TRANSITION_ERROR)) {
                throw CancellationFailed::fromThrowable($e);
            }

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
                            ->withCurrency($requestedAmount->currency()->value),
                        PartialConfirmation: false
                    )
                );

            return new Order(
                OrderId::fromString($response->getOrder()->getUuid()),
                new FiledMerchantTransactionReference(
                    non_empty_string()
                        ->assert($response->getOrder()->getMerchantTransactionReference())
                ),
                OrderStatus::from($response->getOrder()->getStatus()->getStatus()->get_()),
                TransactionStatus::from($response->getOrder()->getStatus()->getReason()->get_()),
                new Money(
                    Currency::from($response->getOrder()->getRequestedAmount()->getCurrency()),
                    $response->getOrder()
                        ->getRequestedAmount()
                        ->getAmount()
                ),
            );
        } catch (SoapException | ValueError | TypeError $e) {
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
                        OperationOrigin: null,
                        Order: (new OrderRequestType())
                            ->withRequestedAmount(
                                (new CurrencyAmountType())
                                    ->withAmount($reversalAmount->amount())
                                    ->withCurrency($reversalAmount->currency()->value)
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
                        CustomerRelationUuid: null,
                        PairingUuid: null,
                        UnidentifiedCustomer: true,
                        ExpressMerchantAuthorization: null,
                        QRCodeRendering: null,
                        PaymentLayerRendering: null,
                        OrderUpdateNotificationURL: null,
                    )
                );

            return new Order(
                OrderId::fromString($response->getOrderUuid()),
                new FiledMerchantTransactionReference((string) $reversalReference),
                OrderStatus::from($response->getOrderStatus()->getStatus()->get_()),
                TransactionStatus::from($response->getOrderStatus()->getReason()->get_()),
                $reversalAmount
            );
        } catch (SoapException | ValueError | TypeError $e) {
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
        return $this->doRequestFastCheckoutCheckIn($amountWithoutShipping, $scopes, $shippingMethods, 'custom');
    }

    /**
     * @throws SdkError
     */
    #[Override]
    public function requestHostedFastCheckoutCheckIn(
        Money $amountWithoutShipping,
        CustomerDataScopes $scopes,
        ShippingMethods $shippingMethods
    ): InteractiveFastCheckoutCheckIn {
        return $this->doRequestFastCheckoutCheckIn($amountWithoutShipping, $scopes, $shippingMethods, 'hosted');
    }

    /**
     * @param 'custom'|'hosted' $uiType
     * @throws SdkError
     * @return ($uiType is 'custom' ? InteractiveFastCheckoutCheckIn<QrCode, null> : InteractiveFastCheckoutCheckIn<null, PaymentUrl>)
     */
    private function doRequestFastCheckoutCheckIn(
        Money $amountWithoutShipping,
        CustomerDataScopes $scopes,
        ShippingMethods $shippingMethods,
        string $uiType
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
                            ->withCurrency($amountWithoutShipping->currency()->value),
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
                                        ->withCurrency($method->price()->currency()->value)
                                ),
                            iterator_to_array($shippingMethods)
                        ),
                        QRCodeRendering: $uiType === 'custom' ? true : null,
                        PaymentLayerRendering: $uiType === 'hosted' ? 'PAYMENT_PAGE' : null,
                    )
                );

            $pairingUuid = PairingUuid::fromString(
                non_empty_string()
                    ->assert($response->getCheckInNotification()->getPairingUuid())
            );
            $pairingStatus = PairingStatus::from($response->getCheckInNotification()->getPairingStatus());
            $pairingToken = AlphanumericPairingToken::fromString($response->getToken()->getDisplayToken());
            if ($uiType === 'custom') {
                return new InteractiveFastCheckoutCheckIn(
                    $pairingUuid,
                    $pairingStatus,
                    $pairingToken,
                    new QrCode(non_empty_string()->assert($response->getQRCode())),
                    null
                );
            }
            return new InteractiveFastCheckoutCheckIn(
                $pairingUuid,
                $pairingStatus,
                $pairingToken,
                null,
                new PaymentUrl(new Url(non_empty_string()->assert($response->getTwintURL())))
            );
        } catch (SoapException | ValueError | TypeError $e) {
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
                        CustomerDataScopes::EMAIL => new Email(non_empty_string()->assert($field->getValue())),
                        CustomerDataScopes::PHONE_NUMBER => new PhoneNumber(
                            non_empty_string()
                                ->assert($field->getValue())
                        ),
                        CustomerDataScopes::SHIPPING_ADDRESS => Address::parse($field->getValue()),
                        default => null, // @codeCoverageIgnore
                    };
                }

                $customerData = CustomerData::fromDict($data);
            }

            return new FastCheckoutCheckIn(
                $pairingUuid,
                PairingStatus::from($response->getCheckInNotification()->getPairingStatus()),
                $response->getShippingMethodId() !== null
                    ? new ShippingMethodId($response->getShippingMethodId())
                    : null,
                $customerData
            );
        } catch (SoapException | ValueError | TypeError $e) {
            throw ApiFailure::fromThrowable($e);
        }
    }

    /**
     * @throws SdkError
     */
    #[Override]
    public function cancelFastCheckoutCheckIn(PairingUuid $pairingUuid): void
    {
        try {
            $status = $this->soapClient()
                ->cancelCheckIn(
                    new CancelCheckInRequestElement(
                        MerchantInformation: (new MerchantInformationType())
                            ->withMerchantUuid((string) $this->storeUuid)
                            ->withCashRegisterId((string) $this->cashRegisterId),
                        Reason: self::CANCELLATION_REASON_PAYMENT_ABORT,
                        CustomerRelationUuid: null,
                        PairingUuid: (string) $pairingUuid,
                        Coupons: null
                    )
                );

            if ($status->getStatus() !== self::CANCELLATION_STATUS_OK) {
                throw new CancellationFailed(sprintf(
                    'Failed to cancel check-in. Expected status "%s", got status "%s"',
                    self::CANCELLATION_STATUS_OK,
                    $status->getStatus()
                ));
            }
        } catch (SoapException | ValueError | TypeError $e) {
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
                        OperationOrigin: null,
                        Order: (new OrderRequestType())
                            ->withRequestedAmount(
                                (new CurrencyAmountType())
                                    ->withAmount($requestedAmount->amount())
                                    ->withCurrency($requestedAmount->currency()->value)
                            )
                            ->withMerchantTransactionReference((string) $orderReference)
                            ->withType(self::ORDER_KIND_PAYMENT_IMMEDIATE)
                            ->withPostingType(self::POSTING_TYPE_GOODS)
                            ->withConfirmationNeeded(true),
                        Coupons: null,
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
                OrderStatus::from($response->getOrderStatus()->getStatus()->get_()),
                TransactionStatus::from($response->getOrderStatus()->getReason()->get_()),
                $requestedAmount,
                PairingStatus::from($response->getPairingStatus()),
                null,
                null
            );
        } catch (SoapException | ValueError | TypeError $e) {
            throw ApiFailure::fromThrowable($e);
        }
    }

    /**
     * @throws SdkError
     */
    #[Override]
    public function startHostedFastCheckoutOrder(
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
                        OperationOrigin: null,
                        Order: (new OrderRequestType())
                            ->withRequestedAmount(
                                (new CurrencyAmountType())
                                    ->withAmount($requestedAmount->amount())
                                    ->withCurrency($requestedAmount->currency()->value)
                            )
                            ->withMerchantTransactionReference((string) $orderReference)
                            ->withType(self::ORDER_KIND_PAYMENT_IMMEDIATE)
                            ->withPostingType(self::POSTING_TYPE_GOODS)
                            ->withConfirmationNeeded(true),
                        Coupons: null,
                        CustomerRelationUuid: null,
                        PairingUuid: (string) $pairingUuid,
                        UnidentifiedCustomer: true,
                        ExpressMerchantAuthorization: null,
                        QRCodeRendering: null,
                        PaymentLayerRendering: 'PAYMENT_PAGE',
                        OrderUpdateNotificationURL: null
                    )
                );

            return new Order(
                OrderId::fromString($response->getOrderUuid()),
                new FiledMerchantTransactionReference((string) $orderReference),
                OrderStatus::from($response->getOrderStatus()->getStatus()->get_()),
                TransactionStatus::from($response->getOrderStatus()->getReason()->get_()),
                $requestedAmount,
                PairingStatus::from($response->getPairingStatus()),
                null,
                null
            );
        } catch (SoapException | ValueError | TypeError $e) {
            throw ApiFailure::fromThrowable($e);
        }
    }

    /**
     * @throws SdkError
     */
    #[Override]
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
        $contentType = non_empty_vec(string())
            ->assert($response->getHeader('content-type'));
        invariant(count($contentType) === 1, 'Expected single content type header');
        invariant(
            non_empty_vec(string())
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
    #[Override]
    public function getIosAppUrl(IosAppScheme $iosAppScheme, PairingToken $token): Url
    {
        $payload = [
            'app_action_type' => 'TWINT_PAYMENT',
            'extras' => [
                'code' => (string) $token->token(),
            ],
            'referer_app_link' => [
                'target_url' => '',
                'url' => '',
                'app_name' => 'EXTERNAL_WEB_BROWSER',
            ],
            'version' => '6.0',
        ];

        try {
            return new Url(
                sprintf(
                    '%s%s/?%s',
                    $iosAppScheme->scheme(),
                    'applinks',
                    urldecode(http_build_query([
                        'al_applink_data' => json_encode($payload, JSON_THROW_ON_ERROR),
                    ]))
                )
            );
            // @codeCoverageIgnoreStart
        } catch (JsonException $e) {
            throw InvalidValue::fromThrowable($e);
        }
        // @codeCoverageIgnoreEnd
    }

    #[Override]
    public function getAndroidAppUrl(PairingToken $token): Url
    {
        $payload = [
            'action' => 'ch.twint.action.TWINT_PAYMENT',
            'scheme' => 'twint',
            'S.code' => $token->token(),
            'S.startingOrigin' => 'EXTERNAL_WEB_BROWSER',
            'S.browser_fallback_url' => '',
        ];

        return new Url(sprintf('intent://payment#Intent;%s;end', http_build_query($payload, arg_separator: ';')));
    }

    /**
     * @throws SdkError
     */
    private function enrollCashRegister(): void
    {
        $cashRegisterId = (string) $this->cashRegisterId;

        if (in_array($cashRegisterId, self::$enrolledCashRegisters[$this->environment->value] ?? [], true)) {
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
                    )
                );

            self::$enrolledCashRegisters[$this->environment->value][] = $cashRegisterId;
        } catch (SoapException | ValueError | TypeError $e) {
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
        return $this->httpClient ??= ($this->httpClientFactory)($this->fileWriter);
    }

    private function httpRequestFactory(): RequestFactoryInterface
    {
        return $this->httpRequestFactory ??= ($this->httpRequestFactoryFactory)();
    }
}
