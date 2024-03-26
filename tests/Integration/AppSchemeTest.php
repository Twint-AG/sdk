<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Integration;

use PHPUnit\Framework\Attributes\CoversClass;
use Twint\Sdk\ApiClient;
use Twint\Sdk\Checks\PHPUnit\IntegrationTest;
use Twint\Sdk\Checks\PHPUnit\Vcr;

#[CoversClass(ApiClient::class)]
final class AppSchemeTest extends IntegrationTest
{
    #[Vcr(fixtureRevision: 1, requestMatchers: ['method', 'url', 'query_string'])]
    public function testGetIosAppSchemes(): void
    {
        $schemes = $this->client->getIosAppSchemes();

        self::assertGreaterThan(10, count($schemes));

        foreach ($schemes as $scheme) {
            self::assertStringStartsWith('twint-issuer', $scheme->scheme());
            self::assertNotEmpty($scheme->displayName());
        }
    }
}
