<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Integration;

use PHPUnit\Framework\Attributes\CoversClass;
use Twint\Sdk\ApiClient;
use Twint\Sdk\Tools\PHPUnit\Vcr;
use Twint\Sdk\Value\Money;
use Twint\Sdk\Value\OrderStatus;
use Twint\Sdk\Value\PairingStatus;
use Twint\Sdk\Value\TransactionStatus;

#[CoversClass(ApiClient::class)]
final class RegularCheckoutTest extends IntegrationTest
{
    private const WIREMOCK_SCENARIO_NAME_SUCCESS = 'SuccessScenario';

    private const WIREMOCK_SCENARIO_NAME_FAILURE = 'FailureScenario';

    private const WIREMOCK_SCENARIO_STATE_SUCCESS_SETUP = 'SetupSuccess';

    private const WIREMOCK_SCENARIO_STATE_FAILURE_SETUP = 'SetupFailure';

    private const WIREMOCK_SCENARIO_STATE_FAILURE_SETUP_CLIENT_TIMEOUT = 'SetupFailureClientTimeout';

    private const WIREMOCK_SCENARIO_STATE_FAILURE_SETUP_CLIENT_ABORT = 'SetupFailureClientAborted';

    private const WIREMOCK_SCENARIO_STATE_FAILURE_SETUP_GENERAL_ERROR = 'SetupFailureGeneralError';

    public function testStartOrder(): void
    {
        $order = $this->client->startOrder($this->createTransactionReference(), Money::CHF(100));

        self::assertEquals(OrderStatus::IN_PROGRESS(), $order->status());
        self::assertTrue($order->requiresPairing());
        self::assertNotNull($order->pairingStatus());
        self::assertEquals(PairingStatus::PAIRING_IN_PROGRESS(), $order->pairingStatus());
        self::assertNotNull($order->pairingToken());
    }

    public function testMonitorOrderByOrderId(): void
    {
        $transactionReference = $this->createTransactionReference();

        $order = $this->client->startOrder($transactionReference, Money::CHF(100));

        $monitorOrder = $this->client->monitorOrder($order->id());

        self::assertEquals($order->id(), $monitorOrder->id());
        self::assertEquals($order->transactionStatus(), $monitorOrder->transactionStatus());
        self::assertEquals($order->pairingStatus(), $monitorOrder->pairingStatus());
    }

    public function testMonitorOrderByMerchantTransactionReference(): void
    {
        $transactionReference = $this->createTransactionReference();

        $order = $this->client->startOrder($transactionReference, Money::CHF(100));

        $monitorOrder = $this->client->monitorOrder($order->merchantTransactionReference());

        self::assertEquals($order->id(), $monitorOrder->id());
        self::assertEquals($order->transactionStatus(), $monitorOrder->transactionStatus());
        self::assertEquals($order->pairingStatus(), $monitorOrder->pairingStatus());
    }

    #[Vcr(fixtureRevision: 1, requestMatchers: self::SOAP_REQUEST_MATCHERS)]
    public function testConfirmOrderByOrderId(): void
    {
        $transactionReference = $this->createTransactionReference();

        $order = $this->client->startOrder($transactionReference, Money::CHF(100));

        $confirmedOrder = $this->client->confirmOrder($order->id(), Money::CHF(100));

        self::assertTrue($confirmedOrder->status()->equals(OrderStatus::SUCCESS()));
    }

    #[Vcr(fixtureRevision: 1, requestMatchers: self::SOAP_REQUEST_MATCHERS)]
    public function testConfirmOrderByMerchantTransactionReference(): void
    {
        $transactionReference = $this->createTransactionReference();

        $order = $this->client->startOrder($transactionReference, Money::CHF(100));

        $confirmedOrder = $this->client->confirmOrder($order->merchantTransactionReference(), Money::CHF(100));

        self::assertEquals($confirmedOrder->status(), OrderStatus::SUCCESS());
    }

    #[Vcr(fixtureRevision: 2, requestMatchers: self::SOAP_REQUEST_MATCHERS)]
    public function testReverseOrderByOrderId(): void
    {
        $transactionReference = $this->createTransactionReference();

        $order = $this->client->startOrder($transactionReference, Money::CHF(100));

        $reversalReference = $this->createTransactionReference();
        $reversed = $this->client->reverseOrder($reversalReference, $order->id(), Money::CHF(100));

        self::assertFalse($order->merchantTransactionReference()->equals($reversed->merchantTransactionReference()));
        self::assertFalse($reversed->requiresPairing());
    }

    #[Vcr(fixtureRevision: 2, requestMatchers: self::SOAP_REQUEST_MATCHERS)]
    public function testReverseOrderByMerchantTransactionReference(): void
    {
        $transactionReference = $this->createTransactionReference();

        $order = $this->client->startOrder($transactionReference, Money::CHF(100));

        $reversalReference = $this->createTransactionReference();
        $reversed = $this->client->reverseOrder(
            $reversalReference,
            $order->merchantTransactionReference(),
            Money::CHF(100)
        );

        self::assertNotEquals($order->merchantTransactionReference(), $reversed->merchantTransactionReference());
        self::assertFalse($reversed->requiresPairing());
        self::assertNull($reversed->pairingToken());
    }

    public function testCancelOrderByOrderId(): void
    {
        $started = $this->client->startOrder($this->createTransactionReference(), Money::CHF(100));

        $cancelled = $this->client->cancelOrder($started->id());

        self::assertEquals(OrderStatus::FAILURE(), $cancelled->status());
        self::assertEquals(TransactionStatus::MERCHANT_ABORT(), $cancelled->transactionStatus());
    }

    public function testCancelOrderByMerchantTransactionReference(): void
    {
        $started = $this->client->startOrder($this->createTransactionReference(), Money::CHF(100));

        self::markTestSkipped('CancelOrder response does not include UUID. Maybe an API bug?');

        $cancelled = $this->client->cancelOrder($started->merchantTransactionReference()); // @phpstan-ignore-line

        self::assertEquals(OrderStatus::FAILURE(), $cancelled->status());
        self::assertEquals(TransactionStatus::MERCHANT_ABORT(), $cancelled->transactionStatus());
    }

    public function testOrderSuccessScenario(): void
    {
        $this->enableWireMockForSoapMethod('StartOrder', 'MonitorOrder');
        $this->wireMock()
            ->resetAllScenarios();

        $order = $this->client->startOrder($this->createTransactionReference(), Money::CHF(100));

        $this->wireMock()
            ->setScenarioState(self::WIREMOCK_SCENARIO_NAME_SUCCESS, self::WIREMOCK_SCENARIO_STATE_SUCCESS_SETUP);

        $started = $this->client->monitorOrder($order->id());
        self::assertEquals(OrderStatus::IN_PROGRESS(), $started->status());
        self::assertEquals(TransactionStatus::ORDER_RECEIVED(), $started->transactionStatus());
        self::assertEquals(PairingStatus::NO_PAIRING(), $started->pairingStatus());

        $awaitConfirmation = $this->client->monitorOrder($order->id());
        self::assertEquals(OrderStatus::IN_PROGRESS(), $awaitConfirmation->status());
        self::assertEquals(TransactionStatus::ORDER_PENDING(), $awaitConfirmation->transactionStatus());
        self::assertEquals(PairingStatus::PAIRING_ACTIVE(), $awaitConfirmation->pairingStatus());

        $confirmation = $this->client->monitorOrder($order->id());
        self::assertEquals(OrderStatus::SUCCESS(), $confirmation->status());
        self::assertEquals(TransactionStatus::ORDER_OK(), $confirmation->transactionStatus());
        self::assertEquals(PairingStatus::PAIRING_ACTIVE(), $confirmation->pairingStatus());
    }

    public function testOrderFailureScenarioClientTimeout(): void
    {
        $this->enableWireMockForSoapMethod('StartOrder', 'MonitorOrder');
        $this->wireMock()
            ->resetAllScenarios();

        $order = $this->client->startOrder($this->createTransactionReference(), Money::CHF(10));

        $this->wireMock()
            ->setScenarioState(self::WIREMOCK_SCENARIO_NAME_FAILURE, self::WIREMOCK_SCENARIO_STATE_FAILURE_SETUP);

        $started = $this->client->monitorOrder($order->id());
        self::assertEquals(OrderStatus::IN_PROGRESS(), $started->status());
        self::assertEquals(TransactionStatus::ORDER_RECEIVED(), $started->transactionStatus());
        self::assertEquals(PairingStatus::NO_PAIRING(), $started->pairingStatus());

        $started = $this->client->monitorOrder($order->id());
        self::assertEquals(OrderStatus::IN_PROGRESS(), $started->status());
        self::assertEquals(TransactionStatus::ORDER_PENDING(), $started->transactionStatus());
        self::assertEquals(PairingStatus::PAIRING_ACTIVE(), $started->pairingStatus());

        $this->wireMock()
            ->setScenarioState(
                self::WIREMOCK_SCENARIO_NAME_FAILURE,
                self::WIREMOCK_SCENARIO_STATE_FAILURE_SETUP_CLIENT_TIMEOUT
            );

        $started = $this->client->monitorOrder($order->id());
        self::assertEquals(OrderStatus::FAILURE(), $started->status());
        self::assertEquals(TransactionStatus::CLIENT_TIMEOUT(), $started->transactionStatus());
        self::assertEquals(PairingStatus::PAIRING_ACTIVE(), $started->pairingStatus()); // @todo is this correct?
    }

    public function testOrderFailureScenarioClientAbort(): void
    {
        $this->enableWireMockForSoapMethod('StartOrder', 'MonitorOrder');
        $this->wireMock()
            ->resetAllScenarios();

        $order = $this->client->startOrder($this->createTransactionReference(), Money::CHF(10));

        $this->wireMock()
            ->setScenarioState(self::WIREMOCK_SCENARIO_NAME_FAILURE, self::WIREMOCK_SCENARIO_STATE_FAILURE_SETUP);

        $started = $this->client->monitorOrder($order->id());
        self::assertEquals(OrderStatus::IN_PROGRESS(), $started->status());
        self::assertEquals(TransactionStatus::ORDER_RECEIVED(), $started->transactionStatus());
        self::assertEquals(PairingStatus::NO_PAIRING(), $started->pairingStatus());

        $started = $this->client->monitorOrder($order->id());
        self::assertEquals(OrderStatus::IN_PROGRESS(), $started->status());
        self::assertEquals(TransactionStatus::ORDER_PENDING(), $started->transactionStatus());
        self::assertEquals(PairingStatus::PAIRING_ACTIVE(), $started->pairingStatus());

        $this->wireMock()
            ->setScenarioState(
                self::WIREMOCK_SCENARIO_NAME_FAILURE,
                self::WIREMOCK_SCENARIO_STATE_FAILURE_SETUP_CLIENT_ABORT
            );

        $started = $this->client->monitorOrder($order->id());
        self::assertEquals(OrderStatus::FAILURE(), $started->status());
        self::assertEquals(TransactionStatus::CLIENT_ABORT(), $started->transactionStatus());
        self::assertEquals(PairingStatus::PAIRING_ACTIVE(), $started->pairingStatus()); // @todo is this correct?
    }

    public function testOrderFailureScenarioGeneralError(): void
    {
        $this->enableWireMockForSoapMethod('StartOrder', 'MonitorOrder');
        $this->wireMock()
            ->resetAllScenarios();

        $order = $this->client->startOrder($this->createTransactionReference(), Money::CHF(10));

        $this->wireMock()
            ->setScenarioState(self::WIREMOCK_SCENARIO_NAME_FAILURE, self::WIREMOCK_SCENARIO_STATE_FAILURE_SETUP);

        $started = $this->client->monitorOrder($order->id());
        self::assertEquals(OrderStatus::IN_PROGRESS(), $started->status());
        self::assertEquals(TransactionStatus::ORDER_RECEIVED(), $started->transactionStatus());
        self::assertEquals(PairingStatus::NO_PAIRING(), $started->pairingStatus());

        $started = $this->client->monitorOrder($order->id());
        self::assertEquals(OrderStatus::IN_PROGRESS(), $started->status());
        self::assertEquals(TransactionStatus::ORDER_PENDING(), $started->transactionStatus());
        self::assertEquals(PairingStatus::PAIRING_ACTIVE(), $started->pairingStatus());

        $this->wireMock()
            ->setScenarioState(
                self::WIREMOCK_SCENARIO_NAME_FAILURE,
                self::WIREMOCK_SCENARIO_STATE_FAILURE_SETUP_GENERAL_ERROR
            );

        $started = $this->client->monitorOrder($order->id());
        self::assertEquals(OrderStatus::FAILURE(), $started->status());
        self::assertEquals(TransactionStatus::GENERAL_ERROR(), $started->transactionStatus());
        self::assertEquals(PairingStatus::PAIRING_ACTIVE(), $started->pairingStatus()); // @todo is this correct?
    }
}
