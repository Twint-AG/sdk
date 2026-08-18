<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Factory;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Twint\Sdk\Factory\Uuid5Factory;
use Twint\Sdk\Value\Uuid;

/**
 * @internal
 */
#[CoversClass(Uuid5Factory::class)]
final class Uuid5FactoryTest extends TestCase
{
    public function testGeneratesUuid5(): void
    {
        $uuid = (new Uuid5Factory(new Uuid(Uuid5Factory::NAMESPACE_DNS), 'example.com'))();

        self::assertSame('cfbff0d1-9375-5685-968c-48ce8b15ae17', (string) $uuid);
    }
}
