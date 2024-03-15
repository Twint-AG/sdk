<?php

declare(strict_types=1);

namespace Twint\Sdk;

use DateTimeImmutable;

use Phpro\SoapClient\Caller\EngineCaller;
use Phpro\SoapClient\Exception\SoapException;
use Soap\Engine\Engine;
use Twint\Sdk\Certificate\Certificate;
use Twint\Sdk\Exception\SdkError;
use Twint\Sdk\Exception\SoapFailure;
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

    private ?TwintSoapClient $client = null;

    /**
     * @param callable(Certificate): Engine $soapEngineFactory
     */
    public function __construct(
        private readonly Certificate $certificate,
        private readonly mixed $soapEngineFactory = new DefaultSoapEngineFactory()
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
            throw SoapFailure::fromThrowable($e);
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
                new OrderStatus($response->getOrderStatus() ->getStatus()->get_()),
                new TransactionStatus($response->getOrderStatus() ->getReason()->get_()),
                $transactionReference
            );
        } catch (SoapException $e) {
            throw SoapFailure::fromThrowable($e);
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
            throw SoapFailure::fromThrowable($e);
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
            throw SoapFailure::fromThrowable($e);
        }
    }

    private function soapClient(): TwintSoapClient
    {
        return $this->client ??= new TwintSoapClient(new EngineCaller(($this->soapEngineFactory)($this->certificate)));
    }
}
