<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Integration;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Twint\Sdk\ApiClient;
use Twint\Sdk\Certificate;
use Twint\Sdk\Value\MerchantId;

/**
 * @covers \Twint\Sdk\ApiClient::getCertificateValidity
 */
final class CertificateValidityTest extends TestCase
{
    private ApiClient $client;

    protected function setUp(): void
    {
        $this->client = new ApiClient(
            new Certificate($_SERVER['TWINT_SDK_TEST_CERT_P12_PATH'], $_SERVER['TWINT_SDK_TEST_CERT_P12_PASSPHRASE'])
        );
    }

    public function testCertificateValidity(): void
    {
        $validity = $this->client->getCertificateValidity(new MerchantId($_SERVER['TWINT_SDK_TEST_MERCHANT_ID']));

        self::assertIsBool($validity->isRenewalAllowed());
        self::assertInstanceOf(DateTimeImmutable::class, $validity->expiresAt());
    }
}
