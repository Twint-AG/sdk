<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Integration;

use PHPUnit\Framework\Attributes\CoversClass;
use Twint\Sdk\Capability\SystemAdministration;
use Twint\Sdk\Client;

/**
 * @template-extends IntegrationTest<SystemAdministration>
 */
#[CoversClass(Client::class)]
final class SystemAdministrationTest extends IntegrationTest
{
    public function testSystemStatus(): void
    {
        $systemStatus = $this->client->checkSystemStatus();

        self::assertTrue($systemStatus->isOk());
    }
}
