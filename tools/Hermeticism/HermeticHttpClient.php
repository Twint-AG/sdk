<?php

declare(strict_types=1);

namespace Twint\Sdk\Tools\Hermeticism;

use Override;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Enforces {@see Hermeticism} at the PSR-18 layer.
 *
 * This sits below IntegrationTest::wrapTransport(), so a test that overrides that hook
 * (as InvocationRecordingClientTest does) cannot bypass the guard.
 */
final class HermeticHttpClient implements ClientInterface
{
    public function __construct(
        private readonly ClientInterface $client
    ) {
    }

    /**
     * @throws ClientExceptionInterface
     * @throws HermeticismViolated
     */
    #[Override]
    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        Hermeticism::enforce((string) $request->getUri());

        return $this->client->sendRequest($request);
    }
}
