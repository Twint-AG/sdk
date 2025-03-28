<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Util;

use Error;
use Exception;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Throwable;
use Twint\Sdk\Util\Throwables;

/**
 * @internal
 */
#[CoversClass(Throwables::class)]
final class ThrowablesTest extends TestCase
{
    public function testReturnsNullForEmptyStack(): void
    {
        self::assertExceptionMessageChain([], Throwables::chain([]));
    }

    public function testSingleException(): void
    {
        self::assertExceptionMessageChain(['foo'], Throwables::chain([new Exception('foo')]));
    }

    public function testMultipleExceptions(): void
    {
        self::assertExceptionMessageChain(
            ['one', 'two', 'three', 'four', 'five', 'six', 'seven'],
            Throwables::chain([
                new Exception('one'),
                new Exception('two', 0, new Exception('three')),
                new Exception('four'),
                new Exception('five', 0, new Exception('six', 0, new Exception('seven'))),
            ])
        );
    }

    public function testMixedErrorsAndExceptions(): void
    {
        self::assertExceptionMessageChain(
            ['one', 'two', 'three', 'four', 'five', 'six', 'seven'],
            Throwables::chain([
                new Exception('one'),
                new Exception('two', 0, new Exception('three')),
                new Error('four'),
                new Exception('five', 0, new Error('six', 0, new Exception('seven'))),
            ])
        );
    }

    /**
     * @param list<non-empty-string> $expectedMessages
     */
    private static function assertExceptionMessageChain(array $expectedMessages, ?Throwable $chain): void
    {
        $actualMessages = [];
        if ($chain !== null) {
            do {
                $actualMessages[] = $chain->getMessage();
            } while (($chain = $chain->getPrevious()) !== null);
        }

        self::assertSame($expectedMessages, $actualMessages);
    }
}
