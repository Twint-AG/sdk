<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Integration;

use DateTimeImmutable;
use PHPUnit\Framework\Attributes\CoversClass;
use Twint\Sdk\ApiClient;
use Twint\Sdk\Checks\PHPUnit\IntegrationTest;

#[CoversClass(ApiClient::class)]
final class CertificateValidityTest extends IntegrationTest
{
    public function testCertificateValidity(): void
    {
        $certificateValidity = $this->client->getCertificateValidity(self::getMerchantId());

        self::assertIsBool($certificateValidity->isRenewalAllowed());
        self::assertInstanceOf(DateTimeImmutable::class, $certificateValidity->expiresAt());
    }

    public function testRenewCertificate(): void
    {
        var_dump($this->client->renewCertificate(self::getMerchantId()));
    }
}
