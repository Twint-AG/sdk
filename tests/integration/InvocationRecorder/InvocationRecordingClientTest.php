<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Integration\InvocationRecorder;

use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\PreCondition;
use ReflectionClass;
use Soap\Engine\Transport;
use Throwable;
use Twint\Sdk\Capability\CoreCapabilities;
use Twint\Sdk\Client;
use Twint\Sdk\InvocationRecorder\Capability\InvocationRecorder;
use Twint\Sdk\InvocationRecorder\InvocationRecordingClient;
use Twint\Sdk\InvocationRecorder\Soap\MessageRecorder;
use Twint\Sdk\InvocationRecorder\Soap\RecordingTransport;
use Twint\Sdk\InvocationRecorder\Value\Invocation;
use Twint\Sdk\InvocationRecorder\Value\SoapMessage;
use Twint\Sdk\InvocationRecorder\Value\SoapRequest;
use Twint\Sdk\InvocationRecorder\Value\SoapResponse;
use Twint\Sdk\Tests\Integration\IntegrationTest;
use Twint\Sdk\Value\FiledMerchantTransactionReference;
use Twint\Sdk\Value\Money;

/**
 * @template-extends IntegrationTest<InvocationRecorder&CoreCapabilities>
 * @internal
 */
#[CoversClass(InvocationRecordingClient::class)]
#[CoversClass(RecordingTransport::class)]
#[CoversClass(MessageRecorder::class)]
#[CoversClass(Invocation::class)]
#[CoversClass(SoapMessage::class)]
#[CoversClass(SoapRequest::class)]
#[CoversClass(SoapResponse::class)]
final class InvocationRecordingClientTest extends IntegrationTest
{
    private readonly InvocationRecordingClient $recordingClient;

    private readonly MessageRecorder $messageRecorder;

    #[PreCondition]
    protected function setUpRecodingClient(): void
    {
        $this->messageRecorder = new MessageRecorder();
        $this->recordingClient = new InvocationRecordingClient($this->client, $this->messageRecorder);
    }

    public function testSystemStatus(): void
    {
        self::assertCount(0, $this->recordingClient->flushInvocations());

        $systemStatus = $this->recordingClient->checkSystemStatus();

        $invocations = $this->recordingClient->flushInvocations();
        self::assertCount(1, $invocations);

        self::assertSame('checkSystemStatus', $invocations[0]->methodName());
        self::assertCount(0, $invocations[0]->arguments());

        self::assertTrue($invocations[0]->returnedValue());
        self::assertSame($systemStatus, $invocations[0]->returnValue());

        self::assertFalse($invocations[0]->threwException());
        self::assertNull($invocations[0]->exception());

        $soapMessages = $invocations[0]->messages();
        self::assertCount(1, $soapMessages);

        $soapRequest = $soapMessages[0]->request();
        self::assertStringContainsString('twint.ch', (string) $soapRequest->location());
        self::assertSame('CheckSystemStatus', $soapRequest->action());
        self::assertTrue($soapRequest->isSoap11());
        self::assertFalse($soapRequest->isSoap12());
        self::assertSame(SoapRequest::VERSION_1_1, $soapRequest->version());
        self::assertFalse($soapRequest->isOneWay());
        self::assertStringContainsString('CheckSystemStatusRequestElement', $soapRequest->body());

        $soapResponse = $soapMessages[0]->response();
        self::assertNotNull($soapResponse);
        self::assertStringContainsString('CheckSystemStatusResponseElement', $soapResponse->body());

        self::assertFalse($soapMessages[0]->threwException());
        self::assertNull($soapMessages[0]->exception());

        self::assertCount(0, $this->recordingClient->flushInvocations());
    }

    public function testCancelOrderFailure(): void
    {
        $prop = (new ReflectionClass(Client::class))->getProperty('enrolledCashRegisters');
        $prop->setAccessible(true);
        $prop->setValue($this->client, []);

        try {
            $this->recordingClient->cancelOrder(new FiledMerchantTransactionReference('invalid-merchant-ref'));

            self::fail('Expected exception to be thrown');
        } catch (Throwable $t) {
            $invocations = $this->recordingClient->flushInvocations();
            self::assertCount(1, $invocations);

            self::assertSame('cancelOrder', $invocations[0]->methodName());
            self::assertCount(1, $invocations[0]->arguments());
            self::assertInstanceOf(FiledMerchantTransactionReference::class, $invocations[0]->arguments()[0]);
            self::assertSame('invalid-merchant-ref', (string) $invocations[0]->arguments()[0]);

            self::assertFalse($invocations[0]->returnedValue());
            self::assertNull($invocations[0]->returnValue());

            self::assertTrue($invocations[0]->threwException());
            self::assertSame($t, $invocations[0]->exception());

            $soapMessages = $invocations[0]->messages();
            self::assertCount(2, $soapMessages);

            [$enrollCashRegisterSoapMessage, $cancelOrderSoapMessage] = $soapMessages;
            $enrollCashRegisterSoapRequest = $enrollCashRegisterSoapMessage->request();
            self::assertStringContainsString('twint.ch', (string) $enrollCashRegisterSoapRequest->location());
            self::assertSame('EnrollCashRegister', $enrollCashRegisterSoapRequest->action());
            self::assertTrue($enrollCashRegisterSoapRequest->isSoap11());
            self::assertFalse($enrollCashRegisterSoapRequest->isSoap12());
            self::assertSame(SoapRequest::VERSION_1_1, $enrollCashRegisterSoapRequest->version());
            self::assertFalse($enrollCashRegisterSoapRequest->isOneWay());
            self::assertStringContainsString(
                'EnrollCashRegisterRequestElement',
                $enrollCashRegisterSoapRequest->body()
            );

            self::assertNotNull($enrollCashRegisterSoapMessage->response());
            self::assertStringContainsString(
                'EnrollCashRegisterResponseElement',
                $enrollCashRegisterSoapMessage->response()
                    ->body()
            );

            self::assertFalse($enrollCashRegisterSoapMessage->threwException());
            self::assertNull($enrollCashRegisterSoapMessage->exception());

            $cancelOrderSoapRequest = $cancelOrderSoapMessage->request();
            self::assertStringContainsString('twint.ch', (string) $cancelOrderSoapRequest->location());
            self::assertSame('CancelOrder', $cancelOrderSoapRequest->action());
            self::assertTrue($cancelOrderSoapRequest->isSoap11());
            self::assertFalse($cancelOrderSoapRequest->isSoap12());
            self::assertSame(SoapRequest::VERSION_1_1, $cancelOrderSoapRequest->version());
            self::assertFalse($cancelOrderSoapRequest->isOneWay());
            self::assertStringContainsString('CancelOrderRequestElement', $cancelOrderSoapRequest->body());

            self::assertNotNull($cancelOrderSoapMessage->response());
            self::assertStringContainsString('<soap:Fault>', $cancelOrderSoapMessage->response()->body());

            self::assertFalse($cancelOrderSoapMessage->threwException());
            self::assertNull($cancelOrderSoapMessage->exception());
        }
    }

    public function testStartOrder(): void
    {
        $prop = (new ReflectionClass(Client::class))->getProperty('enrolledCashRegisters');
        $prop->setAccessible(true);
        $prop->setValue($this->client, []);

        $transactionRef = self::createTransactionReference();
        $amount = Money::CHF(0.20);
        $order = $this->recordingClient->startOrder($transactionRef, $amount);

        $invocations = $this->recordingClient->flushInvocations();
        self::assertCount(1, $invocations);

        self::assertSame('startOrder', $invocations[0]->methodName());
        self::assertCount(2, $invocations[0]->arguments());
        self::assertSame($transactionRef, $invocations[0]->arguments()[0]);
        self::assertSame($amount, $invocations[0]->arguments()[1]);

        self::assertTrue($invocations[0]->returnedValue());
        self::assertSame($order, $invocations[0]->returnValue());

        self::assertFalse($invocations[0]->threwException());
        self::assertNull($invocations[0]->exception());

        $soapMessages = $invocations[0]->messages();
        self::assertCount(2, $soapMessages);

        [$enrollCashRegisterSoapMessage, $startOrderSoapMessage] = $soapMessages;

        $enrollCashRegisterSoapRequest = $enrollCashRegisterSoapMessage->request();
        self::assertStringContainsString('twint.ch', (string) $enrollCashRegisterSoapRequest->location());
        self::assertSame('EnrollCashRegister', $enrollCashRegisterSoapRequest->action());
        self::assertTrue($enrollCashRegisterSoapRequest->isSoap11());
        self::assertFalse($enrollCashRegisterSoapRequest->isSoap12());
        self::assertSame(SoapRequest::VERSION_1_1, $enrollCashRegisterSoapRequest->version());
        self::assertFalse($enrollCashRegisterSoapRequest->isOneWay());
        self::assertStringContainsString(
            'EnrollCashRegisterRequestElement',
            $enrollCashRegisterSoapRequest->body()
        );

        $enrollCashRegisterSoapResponse = $enrollCashRegisterSoapMessage->response();
        self::assertNotNull($enrollCashRegisterSoapResponse);
        self::assertStringContainsString('EnrollCashRegisterResponseElement', $enrollCashRegisterSoapResponse->body());

        $startOrderSoapRequest = $startOrderSoapMessage->request();
        self::assertStringContainsString('twint.ch', (string) $startOrderSoapRequest->location());
        self::assertSame('StartOrder', $startOrderSoapRequest->action());
        self::assertTrue($startOrderSoapRequest->isSoap11());
        self::assertFalse($startOrderSoapRequest->isSoap12());
        self::assertSame(SoapRequest::VERSION_1_1, $startOrderSoapRequest->version());
        self::assertFalse($startOrderSoapRequest->isOneWay());
        self::assertStringContainsString('StartOrderRequestElement', $startOrderSoapRequest->body());

        $startOrderSoapResponse = $startOrderSoapMessage->response();
        self::assertNotNull($startOrderSoapResponse);
        self::assertStringContainsString('StartOrderResponseElement', $startOrderSoapResponse->body());

        self::assertFalse($soapMessages[1]->threwException());
        self::assertNull($soapMessages[1]->exception());

        self::assertCount(0, $this->recordingClient->flushInvocations());
    }

    #[Override]
    public function wrapTransport(Transport $transport): Transport
    {
        return new RecordingTransport($transport, $this->messageRecorder);
    }
}
