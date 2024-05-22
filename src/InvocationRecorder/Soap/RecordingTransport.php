<?php

declare(strict_types=1);

namespace Twint\Sdk\InvocationRecorder\Soap;

use Override;
use Soap\Engine\HttpBinding\SoapRequest as SoapEngineRequest;
use Soap\Engine\HttpBinding\SoapResponse as SoapEngineResponse;
use Soap\Engine\Transport;
use Throwable;
use Twint\Sdk\InvocationRecorder\Value\SoapMessage;
use Twint\Sdk\InvocationRecorder\Value\SoapRequest;
use Twint\Sdk\InvocationRecorder\Value\SoapResponse;
use Twint\Sdk\Value\Url;

final class RecordingTransport implements Transport
{
    public function __construct(
        private readonly Transport $transport,
        private readonly MessageRecorder $messageRecorder
    ) {
    }

    #[Override]
    public function request(SoapEngineRequest $request): SoapEngineResponse
    {
        try {
            $response = $this->transport->request($request);

            $this->messageRecorder->record(
                SoapMessage::fromResponse(self::convertRequest($request), self::convertResponse($response))
            );

            return $response;
        } catch (Throwable $throwable) {
            $this->messageRecorder->record(SoapMessage::fromException(self::convertRequest($request), $throwable));

            throw $throwable;
        }
    }

    private static function convertRequest(SoapEngineRequest $request): SoapRequest
    {
        return new SoapRequest(
            new Url($request->getLocation()),
            $request->getAction(),
            $request->getVersion(),
            $request->getOneWay(),
            $request->getRequest()
        );
    }

    private static function convertResponse(SoapEngineResponse $response): SoapResponse
    {
        return new SoapResponse($response->getPayload());
    }
}
