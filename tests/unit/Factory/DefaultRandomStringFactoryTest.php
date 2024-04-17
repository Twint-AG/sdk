<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Factory;

use Exception;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Twint\Sdk\Exception\CryptographyFailure;
use Twint\Sdk\Factory\DefaultRandomStringFactory;

#[CoversClass(DefaultRandomStringFactory::class)]
final class DefaultRandomStringFactoryTest extends TestCase
{
    public function testGeneratesRandomString(): void
    {
        $randomString = (new DefaultRandomStringFactory())(16);

        self::assertMatchesRegularExpression('/[0-9a-zA-Z]{16}/', $randomString);
    }

    public function testRandomBytesThrowsException(): void
    {
        $this->expectException(CryptographyFailure::class);

        (new DefaultRandomStringFactory(static fn () => throw new Exception()))(16);
    }
}
