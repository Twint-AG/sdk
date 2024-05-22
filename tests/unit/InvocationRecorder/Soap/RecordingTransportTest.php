<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\InvocationRecorder;

use Exception;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Soap\Engine\HttpBinding\SoapRequest as SoapEngineRequest;
use Soap\Engine\HttpBinding\SoapResponse as SoapEngineResponse;
use Soap\Engine\Transport;
use Twint\Sdk\InvocationRecorder\Soap\MessageRecorder;
use Twint\Sdk\InvocationRecorder\Soap\RecordingTransport;
use Twint\Sdk\InvocationRecorder\Value\SoapMessage;

/**
 * @internal
 */
#[CoversClass(RecordingTransport::class)]
#[CoversClass(SoapMessage::class)]
final class RecordingTransportTest extends TestCase
{
    public function testSuccessfulRequestIsRecorded(): void
    {
        $recorder = new MessageRecorder();
        $innerResponse = new SoapEngineResponse('body');

        $transport = new RecordingTransport(
            $this->createConfiguredMock(Transport::class, [
                'request' => $innerResponse,
            ]),
            $recorder
        );
        $request = new SoapEngineRequest('body', 'http://endpoint.com', 'action', SoapEngineRequest::SOAP_1_1);

        $response = $transport->request($request);

        $messages = $recorder->flush();

        self::assertCount(1, $messages);

        self::assertSame($request->getAction(), $messages[0]->request()->action());
        self::assertSame($request->getLocation(), (string) $messages[0]->request()->location());
        self::assertSame($request->getVersion(), $messages[0]->request()->version());
        self::assertSame($request->getRequest(), $messages[0]->request()->body());

        self::assertFalse($messages[0]->threwException());
        self::assertNull($messages[0]->exception());
        self::assertSame($response->getPayload(), $messages[0]->response()->body());
    }

    public function testFailedRequestsAreRecorded(): void
    {
        $recorder = new MessageRecorder();

        $innerTransport = $this->createMock(Transport::class);
        $exception = new Exception('error');
        $innerTransport
            ->method('request')
            ->willThrowException($exception);

        $transport = new RecordingTransport($innerTransport, $recorder);
        $request = new SoapEngineRequest('body', 'http://endpoint.com', 'action', SoapEngineRequest::SOAP_1_1);

        try {
            $transport->request($request);
            self::fail('Expected exception');
        } catch (Exception $e) {
            $messages = $recorder->flush();

            self::assertCount(1, $messages);

            self::assertSame($request->getAction(), $messages[0]->request()->action());
            self::assertSame($request->getLocation(), (string) $messages[0]->request()->location());
            self::assertSame($request->getVersion(), $messages[0]->request()->version());
            self::assertSame($request->getRequest(), $messages[0]->request()->body());

            self::assertTrue($messages[0]->threwException());
            self::assertSame($exception, $messages[0]->exception());
            self::assertNull($messages[0]->response());
        }
    }
}
