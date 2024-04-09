<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Integration;

use PHPUnit\Framework\Attributes\CoversClass;
use Twint\Sdk\ApiClient;

#[CoversClass(ApiClient::class)]
final class AppSchemeTest extends IntegrationTest
{
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
