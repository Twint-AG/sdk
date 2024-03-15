<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Integration;

use DateTimeImmutable;
use Twint\Sdk\Checks\PHPUnit\IntegrationTest;

/**
 * @covers \Twint\Sdk\ApiClient::getCertificateValidity
 */
final class CertificateValidityTest extends IntegrationTest
{
    public function testCertificateValidity(): void
    {
        $certificateValidity = $this->client->getCertificateValidity(self::getMerchantId());

        self::assertIsBool($certificateValidity->isRenewalAllowed());
        self::assertInstanceOf(DateTimeImmutable::class, $certificateValidity->expiresAt());
    }
}
