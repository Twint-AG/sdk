<?php

declare(strict_types=1);

namespace Twint\Sdk\Tools\PHPUnit;

use PHPUnit\Framework\Assert;

/**
 * @phpstan-require-extends Assert
 * @mixin Assert
 */
trait Assertions
{
    /**
     * @see https://github.com/sebastianbergmann/phpunit/issues/5811
     */
    public static function assertObjectNotEquals(
        object $expected,
        object $actual,
        string $method = 'equals',
        string $message = ''
    ): void {
        self::assertThat($actual, self::logicalNot(self::objectEquals($expected, $method)), $message);
    }
}
