<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Integration;

use PHPUnit\Framework\Attributes\CoversClass;
use Twint\Sdk\Capability\SystemAdministration;
use Twint\Sdk\Certificate\PemCertificate;
use Twint\Sdk\Client;
use Twint\Sdk\Factory\DefaultHttpClientFactory;
use Twint\Sdk\Factory\DefaultSoapEngineFactory;

/**
 * @template-extends IntegrationTest<SystemAdministration>
 */
#[CoversClass(Client::class)]
#[CoversClass(DefaultSoapEngineFactory::class)]
#[CoversClass(DefaultHttpClientFactory::class)]
#[CoversClass(PemCertificate::class)]
final class SystemAdministrationTest extends IntegrationTest
{
    public function testSystemStatus(): void
    {
        $systemStatus = $this->client->checkSystemStatus();

        self::assertTrue($systemStatus->isOk());
    }
}
