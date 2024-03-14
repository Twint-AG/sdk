<?php

declare(strict_types=1);

namespace Twint\Sdk\Checks\PHPStan;

use Assert\Assertion as BaseAssertion;
use PhpParser\Node\Expr\StaticCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Type\DynamicStaticMethodThrowTypeExtension;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use ReflectionClass;

final class AssertionThrowTypeExtension implements DynamicStaticMethodThrowTypeExtension
{
    private static array $exceptionClasses = [];

    public function __construct(
        private readonly ReflectionProvider $reflectionProvider
    ) {
    }

    private static function getExceptionClass(StaticCall $methodCall): string
    {
        $className = $methodCall->class->toString();

        return self::$exceptionClasses[$className] ??= (new ReflectionClass($className))->getProperty(
            'exceptionClass'
        )->getDefaultValue();
    }

    public function isStaticMethodSupported(MethodReflection $methodReflection): bool
    {
        return $methodReflection->getDeclaringClass()
            ->getName() === BaseAssertion::class;
    }

    public function getThrowTypeFromStaticMethodCall(
        MethodReflection $methodReflection,
        StaticCall $methodCall,
        Scope $scope
    ): ?Type {
        if ($methodCall->class->toString() === BaseAssertion::class || $methodReflection->getThrowType() === null) {
            return $methodReflection->getThrowType();
        }

        return new ObjectType(self::getExceptionClass($methodCall));
    }
}
