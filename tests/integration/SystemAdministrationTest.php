<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Integration;

use PHPUnit\Framework\Attributes\CoversClass;
use Twint\Sdk\Capability\SystemAdministration;
use Twint\Sdk\Client;
use Twint\Sdk\Factory\DefaultHttpClientFactory;
use Twint\Sdk\Factory\DefaultSoapEngineFactory;
use Twint\Sdk\Util\Resilience;

/**
 * @template-extends IntegrationTest<SystemAdministration>
 * @internal
 */
#[CoversClass(Client::class)]
#[CoversClass(DefaultSoapEngineFactory::class)]
#[CoversClass(DefaultHttpClientFactory::class)]
final class SystemAdministrationTest extends IntegrationTest
{
    public function testSystemStatus(): void
    {
        Resilience::retry(3, function () {
            $systemStatus = $this->createClient()
                ->checkSystemStatus();

            self::assertTrue($systemStatus->isOk());
        });
    }
}
