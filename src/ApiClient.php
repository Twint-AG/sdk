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
use Twint\Sdk\Certificate\Certificate;
use Twint\Sdk\Exception\ApiFailure;
use Twint\Sdk\Exception\SdkError;
use Twint\Sdk\Factory\DefaultHttpClientFactory;
use Twint\Sdk\Factory\DefaultSoapEngineFactory;
use Twint\Sdk\Generated\TwintSoapClient;
use Twint\Sdk\Generated\Type\CurrencyAmountType;
use Twint\Sdk\Generated\Type\EnrollCashRegisterRequestType;
use Twint\Sdk\Generated\Type\GetCertificateValidityRequestType;
use Twint\Sdk\Generated\Type\MerchantInformationType;
use Twint\Sdk\Generated\Type\MonitorOrderRequestType;
use Twint\Sdk\Generated\Type\OrderRequestType;
use Twint\Sdk\Generated\Type\StartOrderRequestType;
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

final class ApiClient implements Client
{
    private const POSTING_TYPE_GOODS = 'GOODS';

    private const CASH_REGISTER_TYPE_EPOS = 'EPOS';

    private ?TwintSoapClient $soapClient = null;

    private ?ClientInterface $httpClient = null;

    private ?RequestFactoryInterface $httpRequestFactory = null;

    /**
     * @param callable(Certificate, TwintVersion, TwintEnvironment): Engine $soapEngineFactory
     * @param callable(Certificate): ClientInterface $httpClientFactory
     * @param callable(): RequestFactoryInterface $httpRequestFactoryFactory
     */
    public function __construct(
        private readonly Certificate $certificate,
        private readonly TwintVersion $version,
        private readonly TwintEnvironment $environment,
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
                ->getCertificateValidity(
                    new GetCertificateValidityRequestType((string) $merchantId, MerchantAliasId: '')
                );
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
    public function startOrder(
        MerchantId $merchantId,
        Money $requestedAmount,
        OrderKind $orderKind,
        TransactionReference $transactionReference,
    ): Order {
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
                new TransactionReference($response->getOrder()->getMerchantTransactionReference()),
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
                new TransactionReference($response->getOrder()->getMerchantTransactionReference()),
            );
        } catch (SoapException $e) {
            throw ApiFailure::fromThrowable($e);
        }
    }

    /**
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

        Assertion::eq(
            200,
            $response->getStatusCode(),
            'Failed to fetch iOS app schemes. Expected status code %s, got %s'
        );
        $contentType = $response->getHeader('content-type');
        Assertion::count($contentType, 1, 'Expected single content type header');
        Assertion::eq('application/json', $contentType[0], 'Invalid content type. Expected "%s", got "%s"');

        try {
            $parsed = json_decode($response->getBody()->getContents(), true, flags: JSON_THROW_ON_ERROR);
        } catch (Throwable $e) {
            throw ApiFailure::fromThrowable($e);
        }

        Assertion::isArray($parsed, 'Parsed response must be an array');
        Assertion::keyExists($parsed, 'appSwitchConfigList', 'Parsed response must contain appSwitchConfigList');
        Assertion::isArray($parsed['appSwitchConfigList'], 'appSwitchConfigList must be an array');
        Assertion::allKeyExists(
            $parsed['appSwitchConfigList'],
            'issuerUrlScheme',
            'issuerUrlScheme must exist in each appSwitchConfigList item'
        );
        Assertion::allKeyExists(
            $parsed['appSwitchConfigList'],
            'displayName',
            'displayName must exist in each appSwitchConfigList item'
        );

        return array_map(
            static fn (array $config) => new IosAppScheme($config['issuerUrlScheme'], $config['displayName']),
            $parsed['appSwitchConfigList']
        );
    }

    private function soapClient(): TwintSoapClient
    {
        return $this->soapClient ??= new TwintSoapClient(
            new EngineCaller(($this->soapEngineFactory)($this->certificate, $this->version, $this->environment))
        );
    }

    private function httpClient(): ClientInterface
    {
        return $this->httpClient ??= ($this->httpClientFactory)($this->certificate);
    }

    private function httpRequestFactory(): RequestFactoryInterface
    {
        return $this->httpRequestFactory ??= ($this->httpRequestFactoryFactory)();
    }
}
