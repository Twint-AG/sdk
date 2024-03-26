<?php

declare(strict_types=1);

namespace Twint\Sdk\Checks\PHPUnit;

use PHPUnit\Event\Code\Test;
use PHPUnit\Event\Code\TestMethod;
use ReflectionMethod;
use Twint\Sdk\Assertion;

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

        Assertion::string($name, 'Cassette name must be a string');

        return $name;
    }

    public static function tryGetFixtureRevision(Test $test): ?int
    {
        return self::tryGetAttribute($test)?->fixtureRevision;
    }

    public static function getFixtureRevision(Test $test): int
    {
        $fixtureRevision = self::tryGetFixtureRevision($test);

        Assertion::integer($fixtureRevision, 'Fixture fixture revision must be set for VCR recording, "%s" given');

        return $fixtureRevision;
    }
}
