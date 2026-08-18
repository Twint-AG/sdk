<?php

declare(strict_types=1);

namespace Twint\Sdk\Util;

use Error;
use Exception;
use ReflectionClass;
use ReflectionException;
use ReflectionProperty;
use Throwable;
use Twint\Sdk\Exception\IoError;

/**
 * @internal
 */
final class Throwables
{
    /**
     * @var array{?ReflectionProperty, ?ReflectionProperty}
     */
    private static $previousPropertiesReflected = [null, null];

    /**
     * @param list<Throwable> $throwables
     * @throws IoError
     */
    public static function chain(array $throwables): ?Throwable
    {
        $head = $tail = array_shift($throwables);

        if ($tail === null) {
            return null;
        }

        while (($current = array_shift($throwables)) !== null) {
            while ($tail->getPrevious() !== null) {
                $tail = $tail->getPrevious();
            }

            try {
                self::getPreviousProperty($tail)->setValue($tail, $current);
                $tail = $current;

                // @codeCoverageIgnoreStart
            } catch (ReflectionException $e) {
                // Just give up
                break;
                // @codeCoverageIgnoreEnd
            }
        }

        return $head;
    }

    /**
     * @throws ReflectionException
     * @phpstan-impure
     */
    private static function getPreviousProperty(Throwable $t): ReflectionProperty
    {
        /** @var array{class-string<Error>, class-string<Exception>} $classMap */
        static $classMap = [Error::class, Exception::class];
        $index = $t instanceof Error ? 0 : 1;

        return self::$previousPropertiesReflected[$index] ??=
            (new ReflectionClass($classMap[$index]))->getProperty('previous');
    }
}
