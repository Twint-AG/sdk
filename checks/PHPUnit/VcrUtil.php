<?php

declare(strict_types=1);

namespace Twint\Sdk\Checks\PHPUnit;

use PHPUnit\Event\Code\Test;
use PHPUnit\Event\Code\TestMethod;
use ReflectionMethod;
use function Psl\Type\non_empty_string;
use function Psl\Type\uint;

final class VcrUtil
{
    public static function tryGetAttribute(Test $test): ?Vcr
    {
        if (!$test instanceof TestMethod) {
            return null;
        }

        $reflection = new ReflectionMethod($test->className(), $test->methodName());

        foreach ($reflection->getAttributes() as $attribute) {
            if ($attribute->getName() === Vcr::class) {
                /** @var Vcr */
                return $attribute->newInstance();
            }
        }

        return null;
    }

    public static function getCassetteName(Test $test): string
    {
        $name = preg_replace(
            '/[^\w_-]/',
            '_',
            $test instanceof TestMethod ?
            sprintf('%s-%s', $test->className(), $test->methodName())
            : $test->id()
        );

        return non_empty_string()->assert($name);
    }

    public static function tryGetFixtureRevision(Test $test): ?int
    {
        return self::tryGetAttribute($test)?->fixtureRevision;
    }

    public static function getFixtureRevision(Test $test): int
    {
        return uint()->assert(self::tryGetFixtureRevision($test));
    }
}
