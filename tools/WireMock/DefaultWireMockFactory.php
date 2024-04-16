<?php

declare(strict_types=1);

namespace Twint\Sdk\Tools\WireMock;

use Psl\Type\Exception\AssertException;
use Twint\Sdk\Tools\SystemEnvironment;
use WireMock\Client\Authentication\TokenAuthenticator;
use WireMock\Client\Curl;
use WireMock\Client\HttpWait;
use WireMock\Client\WireMock;
use WireMock\Serde\SerializerFactory;
use function Psl\Type\non_empty_string;
use function Psl\Type\optional;
use function Psl\Type\shape;
use function Psl\Type\uint;

final class DefaultWireMockFactory
{
    public function __invoke(): WireMock
    {
        $baseUrl = SystemEnvironment::get('TWINT_SDK_TEST_WIREMOCK_BASE_URL');
        $urlParts = shape([
            'host' => non_empty_string(),
            'port' => optional(uint()),
            'scheme' => non_empty_string(),
        ], true)->assert(parse_url($baseUrl));

        try {
            $curl = new Curl(new TokenAuthenticator(SystemEnvironment::get('TWINT_SDK_TEST_WIREMOCK_AUTH_TOKEN')));
        } catch (AssertException $e) {
            $curl = new Curl();
        }

        $httpWait = new HttpWait($curl);
        return new WireMock(
            $httpWait,
            $curl,
            SerializerFactory::default(),
            $urlParts['host'],
            $urlParts['port'] ?? ($urlParts['scheme'] === 'https' ? 443 : 80),
            $urlParts['scheme']
        );
    }
}
