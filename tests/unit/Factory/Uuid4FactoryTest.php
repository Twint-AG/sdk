<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Factory;

use Exception;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Twint\Sdk\Exception\CryptographyFailure;
use Twint\Sdk\Factory\Uuid4Factory;

/**
 * @internal
 */
#[CoversClass(Uuid4Factory::class)]
#[CoversClass(CryptographyFailure::class)]
final class Uuid4FactoryTest extends TestCase
{
    public function testGeneratesUuid4(): void
    {
        $uuid = (new Uuid4Factory())();

        self::assertMatchesRegularExpression(
            '/[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}/',
            (string) $uuid
        );
    }

    public function testThrowsCryptographicFailureWhenRandomBytesThrowsException(): void
    {
        $this->expectException(CryptographyFailure::class);

        (new Uuid4Factory(static fn () => throw new Exception()))();
    }
}
