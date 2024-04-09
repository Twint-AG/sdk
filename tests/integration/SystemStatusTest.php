<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Integration;

use PHPUnit\Framework\Attributes\CoversClass;
use Twint\Sdk\ApiClient;

#[CoversClass(ApiClient::class)]
final class SystemStatusTest extends IntegrationTest
{
    public function testSystemStatus(): void
    {
        $systemStatus = $this->client->checkSystemStatus();

        self::assertTrue($systemStatus->isOk());
    }
}
