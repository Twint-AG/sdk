<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Factory;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Twint\Sdk\Factory\StaticFileFactory;
use Twint\Sdk\Value\ExistingPath;

/**
 * @internal
 */
#[CoversClass(StaticFileFactory::class)]
final class StaticFileFactoryTest extends TestCase
{
    public function testReturnsProvidedFile(): void
    {
        $file = new ExistingPath(__FILE__);
        $factory = new StaticFileFactory($file);

        self::assertObjectEquals($file, $factory());
    }
}
