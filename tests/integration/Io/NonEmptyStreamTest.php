<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Integration\Io;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Psl\Type\Exception\AssertException;
use Twint\Sdk\Io\InMemoryStream;
use Twint\Sdk\Io\NonEmptyStream;

/**
 * @internal
 */
#[CoversClass(NonEmptyStream::class)]
final class NonEmptyStreamTest extends TestCase
{
    public function testReturnNonEmptyString(): void
    {
        self::assertSame('foo', (new NonEmptyStream(new InMemoryStream('foo')))->read());
    }

    public function testReturnNonEmptyStringWithEmptyString(): void
    {
        $this->expectException(AssertException::class);
        (new NonEmptyStream(new InMemoryStream('')))->read();
    }
}
