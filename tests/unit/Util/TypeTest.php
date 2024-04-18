<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Util;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Twint\Sdk\Util\Type;
use function Psl\Type\int;
use function Psl\Type\string;

/**
 * @internal
 */
#[CoversClass(Type::class)]
final class TypeTest extends TestCase
{
    public function testUnionOfLiterals(): void
    {
        self::assertSame('foo', Type::maybeUnionOfLiterals('foo', 'bar')->assert('foo'));
    }

    public function testUnionWithSingleLiteral(): void
    {
        self::assertSame('foo', Type::maybeUnionOfLiterals('foo')->assert('foo'));
    }

    public function testUnion(): void
    {
        self::assertSame(1, Type::maybeUnion(string(), int())->assert(1));
    }

    public function testUnionWithSingleType(): void
    {
        self::assertSame('foo', Type::maybeUnion(string())->assert('foo'));
    }
}
