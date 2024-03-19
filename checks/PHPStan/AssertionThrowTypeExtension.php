<?php

declare(strict_types=1);

namespace Twint\Sdk\Checks\PHPStan;

use Assert\Assertion as BaseAssertion;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Name;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Type\DynamicStaticMethodThrowTypeExtension;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use ReflectionClass;
use ReflectionException;
use Twint\Sdk\Assertion;
use Twint\Sdk\Exception\AssertionFailed;

final class AssertionThrowTypeExtension implements DynamicStaticMethodThrowTypeExtension
{
    /**
     * @var array<class-string,class-string>
     */
    private static array $exceptionClasses = [];

    /**
     * @throws AssertionFailed
     * @throws ReflectionException
     */
    private static function getExceptionClass(StaticCall $methodCall): string
    {
        Assertion::isInstanceOf($methodCall->class, Name::class);

        $className = $methodCall->class->toString();

        Assertion::classExists($className);

        return self::$exceptionClasses[$className] ??= self::getExceptionClassFromReflection($className);
    }

    /**
     * @param class-string $className
     * @return class-string
     * @throws AssertionFailed
     * @throws ReflectionException
     */
    private static function getExceptionClassFromReflection(string $className): mixed
    {
        $exceptionClass = (new ReflectionClass($className))
            ->getProperty('exceptionClass')
            ->getDefaultValue();

        Assertion::classExists($exceptionClass);

        return $exceptionClass;
    }

    public function isStaticMethodSupported(MethodReflection $methodReflection): bool
    {
        return $methodReflection
            ->getDeclaringClass()
            ->getName() === BaseAssertion::class;
    }

    /**
     * @throws AssertionFailed
     * @throws ReflectionException
     */
    public function getThrowTypeFromStaticMethodCall(
        MethodReflection $methodReflection,
        StaticCall $methodCall,
        Scope $scope
    ): ?Type {
        if (!$methodCall->class instanceof Name || $methodCall->class->toString() === BaseAssertion::class || $methodReflection->getThrowType() === null) {
            return $methodReflection->getThrowType();
        }

        return new ObjectType(self::getExceptionClass($methodCall));
    }
}
