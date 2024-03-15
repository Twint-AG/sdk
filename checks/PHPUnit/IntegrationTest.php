<?php

declare(strict_types=1);

namespace Twint\Sdk\Checks\PHPUnit;

use PHPUnit\Framework\TestCase;
use Twint\Sdk\ApiClient;
use Twint\Sdk\Assertion;
use Twint\Sdk\Certificate;
use Twint\Sdk\Value\MerchantId;
use Twint\Sdk\Value\TransactionReference;

abstract class IntegrationTest extends TestCase
{
    protected ApiClient $client;

    protected static function getEnvironmentVariable(string $name): string
    {
        $value = $_SERVER[$name] ?? null;

        Assertion::string($value, 'Environment variable ' . $name . ' is not set');

        return $value;
    }

    protected static function getMerchantId(): MerchantId
    {
        return MerchantId::fromString(self::getEnvironmentVariable('TWINT_SDK_TEST_MERCHANT_ID'));
    }

    protected static function createTransactionReference(): TransactionReference
    {
        return new TransactionReference(bin2hex(random_bytes(16)));
    }

    protected function setUp(): void
    {
        $this->client = new ApiClient(
            Certificate\Pkcs12Certificate::read(
                self::getEnvironmentVariable('TWINT_SDK_TEST_CERT_P12_PATH'),
                self::getEnvironmentVariable('TWINT_SDK_TEST_CERT_P12_PASSPHRASE')
            )
        );
    }
}
