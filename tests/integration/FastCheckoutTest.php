<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Integration;

use PHPUnit\Framework\Attributes\CoversClass;
use Twint\Sdk\Capability\FastCheckout;
use Twint\Sdk\Client;
use Twint\Sdk\Value\CustomerDataScopes;
use Twint\Sdk\Value\Money;
use Twint\Sdk\Value\PairingStatus;
use Twint\Sdk\Value\ShippingMethod;
use Twint\Sdk\Value\ShippingMethodId;
use Twint\Sdk\Value\ShippingMethods;
use Twint\Sdk\Value\Version;
use VeeWee\Xml\Dom\Document;
use function Psl\Type\int;
use function Psl\Type\non_empty_string;
use function VeeWee\Xml\Dom\Xpath\Configurator\namespaces;

/**
 * @template-extends IntegrationTest<FastCheckout>
 * @internal
 */
#[CoversClass(Client::class)]
final class FastCheckoutTest extends IntegrationTest
{
    public function testFastCheckoutCheckIn(): void
    {
        $client = $this->createClient(Version::next());

        $fastCheckoutPairing = $client->requestFastCheckoutCheckIn(
            Money::CHF(1000),
            new CustomerDataScopes(
                CustomerDataScopes::EMAIL,
                CustomerDataScopes::SHIPPING_ADDRESS,
                CustomerDataScopes::PHONE_NUMBER,
                CustomerDataScopes::DATE_OF_BIRTH
            ),
            new ShippingMethods()
        );

        self::assertObjectEquals(PairingStatus::PAIRING_IN_PROGRESS(), $fastCheckoutPairing->pairingStatus());
        self::assertFalse($fastCheckoutPairing->isPaired());
    }

    public function testFastCheckoutCheckInWithShippingMethod(): void
    {
        $client = $this->createClient(Version::next());

        $fastCheckoutPairing = $client->requestFastCheckoutCheckIn(
            Money::CHF(1000),
            new CustomerDataScopes(
                CustomerDataScopes::EMAIL,
                CustomerDataScopes::SHIPPING_ADDRESS,
                CustomerDataScopes::PHONE_NUMBER,
                CustomerDataScopes::DATE_OF_BIRTH
            ),
            new ShippingMethods(
                new ShippingMethod(new ShippingMethodId('123'), 'Regular', Money::CHF(1.00)),
                new ShippingMethod(new ShippingMethodId('234'), 'Express', Money::CHF(10.00)),
            )
        );

        self::assertObjectEquals(PairingStatus::PAIRING_IN_PROGRESS(), $fastCheckoutPairing->pairingStatus());
        self::assertFalse($fastCheckoutPairing->isPaired());
    }

    public function testFastCheckoutWithShippingMethod(): void
    {
        $this->enableWireMockForSoapMethod('RequestFastCheckoutCheckIn', 'MonitorFastCheckoutCheckIn', 'StartOrder');
        $this->wireMock()
            ->resetAllScenarios();

        $client = $this->createClient(Version::next());

        $fastCheckoutPairing = $client->requestFastCheckoutCheckIn(
            Money::CHF(1000),
            new CustomerDataScopes(
                CustomerDataScopes::EMAIL,
                CustomerDataScopes::SHIPPING_ADDRESS,
                CustomerDataScopes::PHONE_NUMBER,
                CustomerDataScopes::DATE_OF_BIRTH
            ),
            new ShippingMethods(new ShippingMethod(new ShippingMethodId('123'), 'Regular', Money::CHF(1.00)))
        );
        self::assertObjectEquals(PairingStatus::PAIRING_IN_PROGRESS(), $fastCheckoutPairing->pairingStatus());
        self::assertFalse($fastCheckoutPairing->isPaired());

        $this->wireMock()
            ->setScenarioState('ShippingTwintIDSuccessScenario', 'SetupSuccess');

        $fastCheckoutState = $client->monitorFastCheckoutCheckIn($fastCheckoutPairing->pairingUuid());
        self::assertObjectEquals(PairingStatus::PAIRING_IN_PROGRESS(), $fastCheckoutState->pairingStatus());
        self::assertFalse($fastCheckoutState->isPaired());
        self::assertNull($fastCheckoutState->shippingMethodId());
        self::assertNull($fastCheckoutState->customerData());

        $fastCheckoutState = $client->monitorFastCheckoutCheckIn($fastCheckoutState->pairingUuid());
        self::assertObjectEquals(PairingStatus::PAIRING_IN_PROGRESS(), $fastCheckoutState->pairingStatus());
        self::assertFalse($fastCheckoutState->isPaired());
        self::assertNull($fastCheckoutState->shippingMethodId());
        self::assertNull($fastCheckoutState->customerData());

        $this->wireMock()
            ->setScenarioState('ShippingTwintIDSuccessScenario', 'SetupSuccessConfirm');

        $fastCheckoutState = $client->monitorFastCheckoutCheckIn($fastCheckoutState->pairingUuid());
        self::assertObjectEquals(PairingStatus::PAIRING_ACTIVE(), $fastCheckoutState->pairingStatus());
        self::assertTrue($fastCheckoutState->isPaired());
        self::assertNotNull($fastCheckoutState->shippingMethodId());
        self::assertNotNull($fastCheckoutState->customerData());
        self::assertNotNull($fastCheckoutState->customerData()->email());
        self::assertNotNull($fastCheckoutState->customerData()->shippingAddress());
        self::assertNotNull($fastCheckoutState->customerData()->phoneNumber());
        self::assertNotNull($fastCheckoutState->customerData()->dateOfBirth());

        $this->wireMock()
            ->setScenarioState('ShippingTwintIDSuccessScenario', 'CreateOrder');

        $order = $client->startFastCheckoutOrder(
            $fastCheckoutState->pairingUuid(),
            $this->createTransactionReference(),
            Money::CHF(1.50)
        );
        self::assertNotNull($order);

        $requests = $this->wireMock()
            ->getAllServeEvents(null, 1)
            ->getRequests();
        self::assertCount(1, $requests);

        $xpath = Document::fromXmlString(non_empty_string()->assert($requests[0]->getRequest()->getBody()))
            ->xpath(namespaces([
                'mer' => (string) Version::next()->soapNamespaceForMerchantTypes(),
            ]));

        self::assertSame(1, $xpath->evaluate('count(//mer:Order[@confirmationNeeded="true"])', int()));
    }

    public function testFastCheckoutClientAbort(): void
    {
        $this->enableWireMockForSoapMethod('RequestFastCheckoutCheckIn', 'MonitorFastCheckoutCheckIn');
        $this->wireMock()
            ->resetAllScenarios();

        $client = $this->createClient(Version::next());

        $fastCheckoutPairing = $client->requestFastCheckoutCheckIn(
            Money::CHF(1000),
            new CustomerDataScopes(
                CustomerDataScopes::EMAIL,
                CustomerDataScopes::SHIPPING_ADDRESS,
                CustomerDataScopes::PHONE_NUMBER,
                CustomerDataScopes::DATE_OF_BIRTH
            ),
            new ShippingMethods()
        );
        self::assertObjectEquals(PairingStatus::PAIRING_IN_PROGRESS(), $fastCheckoutPairing->pairingStatus());
        self::assertFalse($fastCheckoutPairing->isPaired());

        $this->wireMock()
            ->setScenarioState('ShippingTwintIDFailureScenario', 'SetupFailure');

        $fastCheckoutState = $client->monitorFastCheckoutCheckIn($fastCheckoutPairing->pairingUuid());
        self::assertObjectEquals(PairingStatus::PAIRING_IN_PROGRESS(), $fastCheckoutState->pairingStatus());
        self::assertFalse($fastCheckoutState->isPaired());
        self::assertNull($fastCheckoutState->shippingMethodId());
        self::assertNull($fastCheckoutState->customerData());

        $fastCheckoutState = $client->monitorFastCheckoutCheckIn($fastCheckoutState->pairingUuid());
        self::assertObjectEquals(PairingStatus::PAIRING_IN_PROGRESS(), $fastCheckoutState->pairingStatus());
        self::assertFalse($fastCheckoutState->isPaired());
        self::assertNull($fastCheckoutState->shippingMethodId());
        self::assertNull($fastCheckoutState->customerData());

        $this->wireMock()
            ->setScenarioState('ShippingTwintIDFailureScenario', 'SetupClientAbort');

        $fastCheckoutState = $client->monitorFastCheckoutCheckIn($fastCheckoutState->pairingUuid());
        self::assertObjectEquals(PairingStatus::NO_PAIRING(), $fastCheckoutState->pairingStatus());
        self::assertFalse($fastCheckoutState->isPaired());
        self::assertNull($fastCheckoutState->shippingMethodId());
        self::assertNull($fastCheckoutState->customerData());
    }

    public function testFastCheckoutMerchantAbort(): void
    {
        $client = $this->createClient(Version::next());

        $fastCheckoutPairing = $client->requestFastCheckoutCheckIn(
            Money::CHF(1000),
            new CustomerDataScopes(
                CustomerDataScopes::EMAIL,
                CustomerDataScopes::SHIPPING_ADDRESS,
                CustomerDataScopes::PHONE_NUMBER,
                CustomerDataScopes::DATE_OF_BIRTH
            ),
            new ShippingMethods()
        );
        self::assertObjectEquals(PairingStatus::PAIRING_IN_PROGRESS(), $fastCheckoutPairing->pairingStatus());
        self::assertFalse($fastCheckoutPairing->isPaired());

        $fastCheckoutState = $client->monitorFastCheckoutCheckIn($fastCheckoutPairing->pairingUuid());
        self::assertObjectEquals(PairingStatus::PAIRING_IN_PROGRESS(), $fastCheckoutState->pairingStatus());
        self::assertFalse($fastCheckoutState->isPaired());
        self::assertNull($fastCheckoutState->shippingMethodId());
        self::assertNull($fastCheckoutState->customerData());

        $client->cancelFastCheckoutCheckIn($fastCheckoutState->pairingUuid());

        $fastCheckoutState = $client->monitorFastCheckoutCheckIn($fastCheckoutPairing->pairingUuid());
        self::assertObjectEquals(PairingStatus::NO_PAIRING(), $fastCheckoutState->pairingStatus());
        self::assertFalse($fastCheckoutState->isPaired());
        self::assertNull($fastCheckoutState->shippingMethodId());
        self::assertNull($fastCheckoutState->customerData());
    }
}
