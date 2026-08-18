<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Integration;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use Twint\Sdk\Capability\OrderCheckout;
use Twint\Sdk\Client;
use Twint\Sdk\Factory\DefaultHttpClientFactory;
use Twint\Sdk\Factory\DefaultSoapEngineFactory;
use Twint\Sdk\Tools\Hermeticism\Empirical;
use Twint\Sdk\Tools\PHPUnit\Assertions;
use Twint\Sdk\Value\Money;
use Twint\Sdk\Value\OrderStatus;
use Twint\Sdk\Value\PairingStatus;
use Twint\Sdk\Value\TransactionStatus;
use Twint\Sdk\Value\Version;
use VeeWee\Xml\Dom\Document;
use WireMock\Client\ServeEvent;
use function Psl\Type\int;
use function Psl\Type\non_empty_string;
use function VeeWee\Xml\Dom\Xpath\Configurator\namespaces;

/**
 * @template-extends IntegrationTest<OrderCheckout>
 * @internal
 */
#[CoversClass(Client::class)]
// Driving SOAP through WireMock exercises the full engine and PSR-18 stack; the only
// other tests declaring these factories are in the empirical group.
#[CoversClass(DefaultSoapEngineFactory::class)]
#[CoversClass(DefaultHttpClientFactory::class)]
final class RegularCheckoutTest extends IntegrationTest
{
    use Assertions;

    private const WIREMOCK_SCENARIO_NAME_SUCCESS = 'SuccessScenario';

    private const WIREMOCK_SCENARIO_NAME_FAILURE = 'FailureScenario';

    private const WIREMOCK_SCENARIO_STATE_SUCCESS_SETUP = 'SetupSuccess';

    private const WIREMOCK_SCENARIO_STATE_FAILURE_SETUP = 'SetupFailure';

    private const WIREMOCK_SCENARIO_STATE_FAILURE_SETUP_CLIENT_TIMEOUT = 'SetupFailureClientTimeout';

    private const WIREMOCK_SCENARIO_STATE_FAILURE_SETUP_CLIENT_ABORT = 'SetupFailureClientAborted';

    private const WIREMOCK_SCENARIO_STATE_FAILURE_SETUP_GENERAL_ERROR = 'SetupFailureGeneralError';

    #[Group(Empirical::GROUP)]
    public function testStartOrder(): void
    {
        self::retry(function () {
            $client = $this->createClient();
            $order = $client->startOrder(self::createTransactionReference(), Money::CHF(100));

            self::assertObjectEquals(OrderStatus::IN_PROGRESS(), $order->status());
            self::assertTrue($order->requiresPairing());
            self::assertNotNull($order->pairingStatus());
            self::assertObjectEquals(PairingStatus::PAIRING_IN_PROGRESS(), $order->pairingStatus());
            self::assertNotNull($order->pairingToken());
            self::assertNotNull($order->qrCode());
        });
    }

    #[Group(Empirical::GROUP)]
    public function testMonitorOrderByOrderId(): void
    {
        self::retry(function () {
            $client = $this->createClient();
            $transactionReference = self::createTransactionReference();

            $order = $client->startOrder($transactionReference, Money::CHF(100));

            $monitorOrder = $client->monitorOrder($order->id());

            self::assertObjectEquals($order->id(), $monitorOrder->id());
            self::assertObjectEquals($order->transactionStatus(), $monitorOrder->transactionStatus());
            self::assertObjectEquals($order->pairingStatus(), $monitorOrder->pairingStatus());
        });
    }

    #[Group(Empirical::GROUP)]
    public function testMonitorOrderByMerchantTransactionReference(): void
    {
        self::retry(function () {
            $client = $this->createClient();
            $transactionReference = self::createTransactionReference();

            $order = $client->startOrder($transactionReference, Money::CHF(100));

            $monitorOrder = $client->monitorOrder($order->merchantTransactionReference());

            self::assertObjectEquals($order->id(), $monitorOrder->id());
            self::assertObjectEquals($order->transactionStatus(), $monitorOrder->transactionStatus());
            self::assertObjectEquals($order->pairingStatus(), $monitorOrder->pairingStatus());
        });
    }

    public function testStartOrderRequiresConfirmation(): void
    {
        self::retry(function () {
            $this->enableWireMockForSoapMethod('StartOrder');

            $version = Version::latest();

            $client = $this->createClient($version);
            $transactionReference = self::createTransactionReference();

            $client->startOrder($transactionReference, Money::CHF(100));

            $requests = $this->wireMock()
                ->getAllServeEvents(null, 1)
                ->getRequests();
            self::assertCount(1, $requests);
            /** @var non-empty-list<ServeEvent> $requests */
            $xpath = Document::fromXmlString(non_empty_string()->assert($requests[0]->getRequest()->getBody()))
                ->xpath(namespaces([
                    'mer' => (string) $version->soapNamespaceForMerchantTypes(),
                ]));

            self::assertSame(1, $xpath->evaluate('count(//mer:Order[@confirmationNeeded="true"])', int()));
        });
    }

    public function testConfirmOrderByOrderId(): void
    {
        self::retry(function () {
            $this->enableWireMockForSoapMethod('StartOrder', 'ConfirmOrder');

            $client = $this->createClient(Version::latest());
            $transactionReference = self::createTransactionReference();

            $order = $client->startOrder($transactionReference, Money::CHF(100));

            $confirmedOrder = $client->confirmOrder($order->id(), Money::CHF(100));

            self::assertObjectEquals($order->id(), $confirmedOrder->id());
            self::assertObjectEquals(OrderStatus::SUCCESS(), $confirmedOrder->status());
        });
    }

    public function testConfirmOrderByMerchantTransactionReference(): void
    {
        self::retry(function () {
            $this->enableWireMockForSoapMethod('StartOrder', 'ConfirmOrder');

            $client = $this->createClient(Version::latest());
            $transactionReference = self::createTransactionReference();

            $order = $client->startOrder($transactionReference, Money::CHF(100));

            $confirmedOrder = $client->confirmOrder($order->merchantTransactionReference(), Money::CHF(100));

            self::assertObjectEquals(
                $order->merchantTransactionReference(),
                $confirmedOrder->merchantTransactionReference()
            );
            self::assertObjectEquals($confirmedOrder->status(), OrderStatus::SUCCESS());
        });
    }

    public function testReverseOrderByOrderId(): void
    {
        self::retry(function () {
            $this->enableWireMockForSoapMethod('StartOrder');

            $client = $this->createClient(Version::latest());
            $transactionReference = self::createTransactionReference();

            $order = $client->startOrder($transactionReference, Money::CHF(100));

            $reversalReference = self::createTransactionReference();
            $reversed = $client->reverseOrder($reversalReference, $order->id(), Money::CHF(100));

            self::assertObjectNotEquals(
                $order->merchantTransactionReference(),
                $reversed->merchantTransactionReference()
            );
            self::assertFalse($reversed->requiresPairing());
        });
    }

    public function testReverseOrderByMerchantTransactionReference(): void
    {
        self::retry(function () {
            $this->enableWireMockForSoapMethod('StartOrder');

            $client = $this->createClient(Version::latest());
            $transactionReference = self::createTransactionReference();

            $order = $client->startOrder($transactionReference, Money::CHF(100));

            $reversalReference = self::createTransactionReference();
            $reversed = $client->reverseOrder(
                $reversalReference,
                $order->merchantTransactionReference(),
                Money::CHF(100)
            );

            self::assertObjectNotEquals(
                $order->merchantTransactionReference(),
                $reversed->merchantTransactionReference()
            );
            self::assertFalse($reversed->requiresPairing());
            self::assertNull($reversed->pairingToken());
        });
    }

    #[Group(Empirical::GROUP)]
    public function testCancelOrderByOrderId(): void
    {
        self::retry(function () {
            $client = $this->createClient();

            $started = $client->startOrder(self::createTransactionReference(), Money::CHF(100));

            $cancelled = $client->cancelOrder($started->id());

            self::assertObjectEquals(OrderStatus::FAILURE(), $cancelled->status());
            self::assertObjectEquals(TransactionStatus::MERCHANT_ABORT(), $cancelled->transactionStatus());
        });
    }

    #[Group(Empirical::GROUP)]
    public function testCancelOrderByMerchantTransactionReference(): void
    {
        self::retry(function () {
            $client = $this->createClient();

            $started = $client->startOrder(self::createTransactionReference(), Money::CHF(100));

            $cancelled = $client->cancelOrder($started->merchantTransactionReference());

            self::assertObjectEquals(OrderStatus::FAILURE(), $cancelled->status());
            self::assertObjectEquals(TransactionStatus::MERCHANT_ABORT(), $cancelled->transactionStatus());
        });
    }

    public function testOrderSuccessScenario(): void
    {
        self::retry(function () {
            $this->enableWireMockForSoapMethod('StartOrder', 'MonitorOrder');
            $this->wireMock()
                ->resetAllScenarios();

            $client = $this->createClient(Version::latest());

            $order = $client->startOrder(self::createTransactionReference(), Money::CHF(100));

            $this->wireMock()
                ->setScenarioState(self::WIREMOCK_SCENARIO_NAME_SUCCESS, self::WIREMOCK_SCENARIO_STATE_SUCCESS_SETUP);

            $started = $client->monitorOrder($order->id());
            self::assertObjectEquals(OrderStatus::IN_PROGRESS(), $started->status());
            self::assertObjectEquals(TransactionStatus::ORDER_RECEIVED(), $started->transactionStatus());
            self::assertObjectEquals(PairingStatus::NO_PAIRING(), $started->pairingStatus());

            $awaitConfirmation = $client->monitorOrder($order->id());
            self::assertObjectEquals(OrderStatus::IN_PROGRESS(), $awaitConfirmation->status());
            self::assertObjectEquals(TransactionStatus::ORDER_PENDING(), $awaitConfirmation->transactionStatus());
            self::assertObjectEquals(PairingStatus::PAIRING_ACTIVE(), $awaitConfirmation->pairingStatus());

            $confirmation = $client->monitorOrder($order->id());
            self::assertObjectEquals(OrderStatus::SUCCESS(), $confirmation->status());
            self::assertObjectEquals(TransactionStatus::ORDER_OK(), $confirmation->transactionStatus());
            self::assertObjectEquals(PairingStatus::PAIRING_ACTIVE(), $confirmation->pairingStatus());
        });
    }

    public function testOrderFailureScenarioClientTimeout(): void
    {
        self::retry(function () {
            $this->enableWireMockForSoapMethod('StartOrder', 'MonitorOrder');
            $this->wireMock()
                ->resetAllScenarios();

            $client = $this->createClient(Version::latest());
            $order = $client->startOrder(self::createTransactionReference(), Money::CHF(10));

            $this->wireMock()
                ->setScenarioState(self::WIREMOCK_SCENARIO_NAME_FAILURE, self::WIREMOCK_SCENARIO_STATE_FAILURE_SETUP);

            $started = $client->monitorOrder($order->id());
            self::assertObjectEquals(OrderStatus::IN_PROGRESS(), $started->status());
            self::assertObjectEquals(TransactionStatus::ORDER_RECEIVED(), $started->transactionStatus());
            self::assertObjectEquals(PairingStatus::NO_PAIRING(), $started->pairingStatus());

            $started = $client->monitorOrder($order->id());
            self::assertObjectEquals(OrderStatus::IN_PROGRESS(), $started->status());
            self::assertObjectEquals(TransactionStatus::ORDER_PENDING(), $started->transactionStatus());
            self::assertObjectEquals(PairingStatus::PAIRING_ACTIVE(), $started->pairingStatus());

            $this->wireMock()
                ->setScenarioState(
                    self::WIREMOCK_SCENARIO_NAME_FAILURE,
                    self::WIREMOCK_SCENARIO_STATE_FAILURE_SETUP_CLIENT_TIMEOUT
                );

            $started = $client->monitorOrder($order->id());
            self::assertObjectEquals(OrderStatus::FAILURE(), $started->status());
            self::assertObjectEquals(TransactionStatus::CLIENT_TIMEOUT(), $started->transactionStatus());
            self::assertObjectEquals(PairingStatus::PAIRING_ACTIVE(), $started->pairingStatus());
        });
    }

    public function testOrderFailureScenarioClientAbort(): void
    {
        self::retry(function () {
            $this->enableWireMockForSoapMethod('StartOrder', 'MonitorOrder');
            $this->wireMock()
                ->resetAllScenarios();

            $client = $this->createClient(Version::latest());
            $order = $client->startOrder(self::createTransactionReference(), Money::CHF(10));

            $this->wireMock()
                ->setScenarioState(self::WIREMOCK_SCENARIO_NAME_FAILURE, self::WIREMOCK_SCENARIO_STATE_FAILURE_SETUP);

            $started = $client->monitorOrder($order->id());
            self::assertObjectEquals(OrderStatus::IN_PROGRESS(), $started->status());
            self::assertObjectEquals(TransactionStatus::ORDER_RECEIVED(), $started->transactionStatus());
            self::assertObjectEquals(PairingStatus::NO_PAIRING(), $started->pairingStatus());

            $started = $client->monitorOrder($order->id());
            self::assertObjectEquals(OrderStatus::IN_PROGRESS(), $started->status());
            self::assertObjectEquals(TransactionStatus::ORDER_PENDING(), $started->transactionStatus());
            self::assertObjectEquals(PairingStatus::PAIRING_ACTIVE(), $started->pairingStatus());

            $this->wireMock()
                ->setScenarioState(
                    self::WIREMOCK_SCENARIO_NAME_FAILURE,
                    self::WIREMOCK_SCENARIO_STATE_FAILURE_SETUP_CLIENT_ABORT
                );

            $started = $client->monitorOrder($order->id());
            self::assertObjectEquals(OrderStatus::FAILURE(), $started->status());
            self::assertObjectEquals(TransactionStatus::CLIENT_ABORT(), $started->transactionStatus());
            self::assertObjectEquals(PairingStatus::PAIRING_ACTIVE(), $started->pairingStatus());
        });
    }

    public function testOrderFailureScenarioGeneralError(): void
    {
        self::retry(function () {
            $this->enableWireMockForSoapMethod('StartOrder', 'MonitorOrder');
            $this->wireMock()
                ->resetAllScenarios();

            $client = $this->createClient(Version::latest());
            $order = $client->startOrder(self::createTransactionReference(), Money::CHF(10));

            $this->wireMock()
                ->setScenarioState(self::WIREMOCK_SCENARIO_NAME_FAILURE, self::WIREMOCK_SCENARIO_STATE_FAILURE_SETUP);

            $started = $client->monitorOrder($order->id());
            self::assertObjectEquals(OrderStatus::IN_PROGRESS(), $started->status());
            self::assertObjectEquals(TransactionStatus::ORDER_RECEIVED(), $started->transactionStatus());
            self::assertObjectEquals(PairingStatus::NO_PAIRING(), $started->pairingStatus());

            $started = $client->monitorOrder($order->id());
            self::assertObjectEquals(OrderStatus::IN_PROGRESS(), $started->status());
            self::assertObjectEquals(TransactionStatus::ORDER_PENDING(), $started->transactionStatus());
            self::assertObjectEquals(PairingStatus::PAIRING_ACTIVE(), $started->pairingStatus());

            $this->wireMock()
                ->setScenarioState(
                    self::WIREMOCK_SCENARIO_NAME_FAILURE,
                    self::WIREMOCK_SCENARIO_STATE_FAILURE_SETUP_GENERAL_ERROR
                );

            $started = $client->monitorOrder($order->id());
            self::assertObjectEquals(OrderStatus::FAILURE(), $started->status());
            self::assertObjectEquals(TransactionStatus::GENERAL_ERROR(), $started->transactionStatus());
            self::assertObjectEquals(PairingStatus::PAIRING_ACTIVE(), $started->pairingStatus());
        });
    }
}
