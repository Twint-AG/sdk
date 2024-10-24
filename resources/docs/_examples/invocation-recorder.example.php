<?php

namespace Acme;

use Soap\Engine\Transport;
use Twint\Sdk\Client;
use Twint\Sdk\Factory\DefaultSoapEngineFactory;
use Twint\Sdk\InvocationRecorder\InvocationRecordingClient;
use Twint\Sdk\InvocationRecorder\Soap\MessageRecorder;
use Twint\Sdk\InvocationRecorder\Soap\RecordingTransport;
use Twint\Sdk\Value\StoreUuid;

$messageRecorder = new MessageRecorder();

$client = new InvocationRecordingClient(
    new Client(
        $certificateContainer,
        StoreUuid::fromString($storeUuid),
        $version,
        $environment,
        soapEngineFactory: new DefaultSoapEngineFactory(
            wrapTransport: static fn (Transport $transport)
                => new RecordingTransport(
                    $transport,
                    $messageRecorder
                )
        )
    ),
    $messageRecorder
);

$status = $client->checkSystemStatus();

$invocations = $client->flushInvocations();
foreach ($invocations as $invocation) {
    // Access method name
    $methodName = $invocation->methodName();
    // Access arguments
    $arguments = $invocation->arguments();
    // Access return value
    $returnValue = $invocation->returnValue();
    // Access exception
    $ex = $invocation->exception();
    // Access SOAP messages
    $soapMessages = $invocation->messages();
}
