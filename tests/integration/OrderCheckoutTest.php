<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Integration;

use PHPUnit\Framework\Attributes\CoversClass;
use Twint\Sdk\Capability\OrderCheckout;
use Twint\Sdk\Client;
use Twint\Sdk\Tools\PHPUnit\Assertions;
use Twint\Sdk\Tools\PHPUnit\Vcr;
use Twint\Sdk\Value\Money;
use Twint\Sdk\Value\OrderStatus;
use Twint\Sdk\Value\PairingStatus;
use Twint\Sdk\Value\TransactionStatus;

/**
 * @template-extends IntegrationTest<OrderCheckout>
 * @internal
 */
#[CoversClass(Client::class)]
final class OrderCheckoutTest extends IntegrationTest
{
    use Assertions;

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

        self::assertObjectEquals(OrderStatus::IN_PROGRESS(), $order->status());
        self::assertTrue($order->requiresPairing());
        self::assertNotNull($order->pairingStatus());
        self::assertObjectEquals(PairingStatus::PAIRING_IN_PROGRESS(), $order->pairingStatus());
        self::assertNotNull($order->pairingToken());
        self::assertNotNull($order->qrCode());
    }

    public function testMonitorOrderByOrderId(): void
    {
        $transactionReference = $this->createTransactionReference();

        $order = $this->client->startOrder($transactionReference, Money::CHF(100));

        $monitorOrder = $this->client->monitorOrder($order->id());

        self::assertObjectEquals($order->id(), $monitorOrder->id());
        self::assertObjectEquals($order->transactionStatus(), $monitorOrder->transactionStatus());
        self::assertObjectEquals($order->pairingStatus(), $monitorOrder->pairingStatus());
    }

    public function testMonitorOrderByMerchantTransactionReference(): void
    {
        $transactionReference = $this->createTransactionReference();

        $order = $this->client->startOrder($transactionReference, Money::CHF(100));

        $monitorOrder = $this->client->monitorOrder($order->merchantTransactionReference());

        self::assertObjectEquals($order->id(), $monitorOrder->id());
        self::assertObjectEquals($order->transactionStatus(), $monitorOrder->transactionStatus());
        self::assertObjectEquals($order->pairingStatus(), $monitorOrder->pairingStatus());
    }

    #[Vcr(fixtureRevision: 3, requestMatchers: self::SOAP_REQUEST_MATCHERS)]
    public function testConfirmOrderByOrderId(): void
    {
        $transactionReference = $this->createTransactionReference();

        $order = $this->client->startOrder($transactionReference, Money::CHF(100));

        $confirmedOrder = $this->client->confirmOrder($order->id(), Money::CHF(100));

        self::assertTrue($confirmedOrder->status()->equals(OrderStatus::SUCCESS()));
    }

    #[Vcr(fixtureRevision: 4, requestMatchers: self::SOAP_REQUEST_MATCHERS)]
    public function testConfirmOrderByMerchantTransactionReference(): void
    {
        $transactionReference = $this->createTransactionReference();

        $order = $this->client->startOrder($transactionReference, Money::CHF(100));

        $confirmedOrder = $this->client->confirmOrder($order->merchantTransactionReference(), Money::CHF(100));

        self::assertObjectEquals($confirmedOrder->status(), OrderStatus::SUCCESS());
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

    #[Vcr(fixtureRevision: 3, requestMatchers: self::SOAP_REQUEST_MATCHERS)]
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

        self::assertObjectNotEquals($order->merchantTransactionReference(), $reversed->merchantTransactionReference());
        self::assertFalse($reversed->requiresPairing());
        self::assertNull($reversed->pairingToken());
    }

    public function testCancelOrderByOrderId(): void
    {
        $started = $this->client->startOrder($this->createTransactionReference(), Money::CHF(100));

        $cancelled = $this->client->cancelOrder($started->id());

        self::assertObjectEquals(OrderStatus::FAILURE(), $cancelled->status());
        self::assertObjectEquals(TransactionStatus::MERCHANT_ABORT(), $cancelled->transactionStatus());
    }

    public function testCancelOrderByMerchantTransactionReference(): void
    {
        $started = $this->client->startOrder($this->createTransactionReference(), Money::CHF(100));

        self::markTestSkipped('CancelOrder response does not include UUID. Maybe an API bug?');

        $cancelled = $this->client->cancelOrder($started->merchantTransactionReference()); // @phpstan-ignore-line

        self::assertObjectEquals(OrderStatus::FAILURE(), $cancelled->status());
        self::assertObjectEquals(TransactionStatus::MERCHANT_ABORT(), $cancelled->transactionStatus());
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
        self::assertObjectEquals(OrderStatus::IN_PROGRESS(), $started->status());
        self::assertObjectEquals(TransactionStatus::ORDER_RECEIVED(), $started->transactionStatus());
        self::assertObjectEquals(PairingStatus::NO_PAIRING(), $started->pairingStatus());

        $awaitConfirmation = $this->client->monitorOrder($order->id());
        self::assertObjectEquals(OrderStatus::IN_PROGRESS(), $awaitConfirmation->status());
        self::assertObjectEquals(TransactionStatus::ORDER_PENDING(), $awaitConfirmation->transactionStatus());
        self::assertObjectEquals(PairingStatus::PAIRING_ACTIVE(), $awaitConfirmation->pairingStatus());

        $confirmation = $this->client->monitorOrder($order->id());
        self::assertObjectEquals(OrderStatus::SUCCESS(), $confirmation->status());
        self::assertObjectEquals(TransactionStatus::ORDER_OK(), $confirmation->transactionStatus());
        self::assertObjectEquals(PairingStatus::PAIRING_ACTIVE(), $confirmation->pairingStatus());
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
        self::assertObjectEquals(OrderStatus::IN_PROGRESS(), $started->status());
        self::assertObjectEquals(TransactionStatus::ORDER_RECEIVED(), $started->transactionStatus());
        self::assertObjectEquals(PairingStatus::NO_PAIRING(), $started->pairingStatus());

        $started = $this->client->monitorOrder($order->id());
        self::assertObjectEquals(OrderStatus::IN_PROGRESS(), $started->status());
        self::assertObjectEquals(TransactionStatus::ORDER_PENDING(), $started->transactionStatus());
        self::assertObjectEquals(PairingStatus::PAIRING_ACTIVE(), $started->pairingStatus());

        $this->wireMock()
            ->setScenarioState(
                self::WIREMOCK_SCENARIO_NAME_FAILURE,
                self::WIREMOCK_SCENARIO_STATE_FAILURE_SETUP_CLIENT_TIMEOUT
            );

        $started = $this->client->monitorOrder($order->id());
        self::assertObjectEquals(OrderStatus::FAILURE(), $started->status());
        self::assertObjectEquals(TransactionStatus::CLIENT_TIMEOUT(), $started->transactionStatus());
        self::assertObjectEquals(
            PairingStatus::PAIRING_ACTIVE(),
            $started->pairingStatus()
        ); // @todo is this correct?
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
        self::assertObjectEquals(OrderStatus::IN_PROGRESS(), $started->status());
        self::assertObjectEquals(TransactionStatus::ORDER_RECEIVED(), $started->transactionStatus());
        self::assertObjectEquals(PairingStatus::NO_PAIRING(), $started->pairingStatus());

        $started = $this->client->monitorOrder($order->id());
        self::assertObjectEquals(OrderStatus::IN_PROGRESS(), $started->status());
        self::assertObjectEquals(TransactionStatus::ORDER_PENDING(), $started->transactionStatus());
        self::assertObjectEquals(PairingStatus::PAIRING_ACTIVE(), $started->pairingStatus());

        $this->wireMock()
            ->setScenarioState(
                self::WIREMOCK_SCENARIO_NAME_FAILURE,
                self::WIREMOCK_SCENARIO_STATE_FAILURE_SETUP_CLIENT_ABORT
            );

        $started = $this->client->monitorOrder($order->id());
        self::assertObjectEquals(OrderStatus::FAILURE(), $started->status());
        self::assertObjectEquals(TransactionStatus::CLIENT_ABORT(), $started->transactionStatus());
        self::assertObjectEquals(
            PairingStatus::PAIRING_ACTIVE(),
            $started->pairingStatus()
        ); // @todo is this correct?
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
        self::assertObjectEquals(OrderStatus::IN_PROGRESS(), $started->status());
        self::assertObjectEquals(TransactionStatus::ORDER_RECEIVED(), $started->transactionStatus());
        self::assertObjectEquals(PairingStatus::NO_PAIRING(), $started->pairingStatus());

        $started = $this->client->monitorOrder($order->id());
        self::assertObjectEquals(OrderStatus::IN_PROGRESS(), $started->status());
        self::assertObjectEquals(TransactionStatus::ORDER_PENDING(), $started->transactionStatus());
        self::assertObjectEquals(PairingStatus::PAIRING_ACTIVE(), $started->pairingStatus());

        $this->wireMock()
            ->setScenarioState(
                self::WIREMOCK_SCENARIO_NAME_FAILURE,
                self::WIREMOCK_SCENARIO_STATE_FAILURE_SETUP_GENERAL_ERROR
            );

        $started = $this->client->monitorOrder($order->id());
        self::assertObjectEquals(OrderStatus::FAILURE(), $started->status());
        self::assertObjectEquals(TransactionStatus::GENERAL_ERROR(), $started->transactionStatus());
        self::assertObjectEquals(
            PairingStatus::PAIRING_ACTIVE(),
            $started->pairingStatus()
        ); // @todo is this correct?
    }
}
