<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Value;

use JsonSerializable;
use Override;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Psl\Type\Exception\AssertException;
use ReflectionClass;
use ReflectionProperty;
use Twint\Sdk\Value\Comparable;
use Twint\Sdk\Value\Enum;
use Twint\Sdk\Value\Equality;
use Twint\Sdk\Value\FixedValues;
use function Psl\Type\int;
use function Psl\Type\string;
use function Psl\Type\union;

/**
 * @template T of (Equality&Comparable)
 */
abstract class ValueTest extends TestCase
{
    /**
     * @var T
     */
    protected readonly object $value;

    protected bool $constNamesEqualsValues = true;

    /**
     * @return iterable<string, array{string, string|int}>
     */
    public static function getValueConstants(): iterable
    {
        $class = new ReflectionClass(static::getValueType());

        if (!$class->implementsInterface(FixedValues::class)) {
            yield 'EMPTY' => ['', ''];
            return;
        }

        foreach ($class->getConstants() as $name => $value) {
            yield $name => [$name, union(string(), int())->assert($value)];
        }
    }

    #[Override]
    protected function setUp(): void
    {
        $this->value = $this->createValue();
    }

    /**
     * @return T
     */
    abstract protected function createValue(): object;

    /**
     * @return class-string<T>
     */
    abstract protected static function getValueType(): string;

    public function testSimpleEquality(): void
    {
        self::assertTrue($this->value->equals($this->value));
    }

    public function testCompareSimpleValue(): void
    {
        self::assertSame(0, $this->value->compare($this->value));
        self::assertSame(0, (clone $this->value)->compare($this->value));
        self::assertSame(0, $this->value->compare(clone $this->value));
    }

    public function testThrowsExceptionIfComparisonValueIsOfDifferentType(): void
    {
        $this->expectException(AssertException::class);

        $this->value->compare(
            new /** @template-implements Comparable<self> */ class() implements Comparable {
                /**
                 * @return 0
                 */
                #[Override]
                public function compare($other): int
                {
                    return 0;
                }
            }
        );
    }

    public function testValueIsFinal(): void
    {
        $class = new ReflectionClass(static::getValueType());
        self::assertTrue($class->isFinal());
    }

    public function testPropertiesArePrivateAndReadonly(): void
    {
        $class = new ReflectionClass(static::getValueType());
        $properties = $class->getProperties();

        if (count($properties) === 0) {
            $this->expectNotToPerformAssertions();
        }

        foreach ($properties as $property) {
            self::assertTrue($property->isPrivate());
            if ($property->isReadOnly()) {
                self::assertTrue($property->isReadOnly());
            } else {
                self::assertIsString($property->getDocComment());
                self::assertStringContainsString('@readonly', $property->getDocComment());
            }
        }
    }

    public function testEnumToString(): void
    {
        if (!method_exists($this->value, '__toString')) {
            self::markTestSkipped('This test is only for values implementing __toString');
        }

        self::assertSame((string) $this->value, (string) $this->value);
    }

    #[DataProvider('getValueConstants')]
    public function testConstantNameAndValueMatches(string $constantName, mixed $constantValue): void
    {
        self::requireEnum();

        if (!$this->constNamesEqualsValues) {
            self::markTestSkipped('Not applicable for this test');
        }

        self::assertSame($constantName, $constantValue);
    }

    #[DataProvider('getValueConstants')]
    public function testNamedConstructorExistsForEachPossibleValue(string $constantName): void
    {
        self::requireEnum();

        $class = new ReflectionClass(static::getValueType());
        self::assertTrue($class->hasMethod($constantName));
        self::assertTrue($class->getMethod($constantName)->isStatic());
        self::assertTrue($class->getMethod($constantName)->isPublic());
    }

    #[DataProvider('getValueConstants')]
    public function testNamedConstructorCanBeUsedToInstantiateValue(string $constantName): void
    {
        self::requireEnum();

        $class = new ReflectionClass(static::getValueType());
        if ($class->getMethod($constantName)->getNumberOfParameters() > 0) {
            self::markTestSkipped('Covers only named constructors with arity 0');
        }

        $value = (static::getValueType())::$constantName(); // @phpstan-ignore-line
        self::assertInstanceOf(static::getValueType(), $value);
    }

    #[DataProvider('getValueConstants')]
    public function testConstantValuesContainedInAll(string $constantName, mixed $constantValue): void
    {
        self::requireFixedValues();

        // @phpstan-ignore-next-line
        self::assertContains($constantValue, (static::getValueType())::all());
    }

    private static function requireFixedValues(): void
    {
        if (!is_subclass_of(static::getValueType(), FixedValues::class)) {
            self::markTestSkipped('This test is only for Enum values');
        }
    }

    private static function requireEnum(): void
    {
        if (!is_subclass_of(static::getValueType(), Enum::class)) {
            self::markTestSkipped('This test is only for Enum values');
        }
    }

    public function testSerialize(): void
    {
        self::assertInstanceOf(JsonSerializable::class, $this->value);

        $class = new ReflectionClass(static::getValueType());
        $properties = $class->getProperties();

        $parent = $class;
        while ($parent = $parent->getParentClass()) {
            $properties = [...$properties, ...$parent->getProperties()];
        }

        $serialized = json_encode($this->value, JSON_THROW_ON_ERROR);
        self::assertJsonStringNotEqualsJsonString('{}', $serialized);

        self::assertGreaterThan(0, count($properties));

        if (count($properties) > 1) {
            $shape = [];
            foreach ($properties as $property) {
                $shape[$property->getName()] = self::propertyToJsonValue($property, $this->value);
            }
            self::assertJsonStringEqualsJsonString(json_encode($shape, JSON_THROW_ON_ERROR), $serialized);
        } else {
            self::assertJsonStringEqualsJsonString(
                json_encode(self::propertyToJsonValue($properties[0], $this->value), JSON_THROW_ON_ERROR),
                $serialized
            );
        }
    }

    private static function propertyToJsonValue(ReflectionProperty $property, JsonSerializable $value): mixed
    {
        $property->setAccessible(true);
        $value = $property->getValue($value);

        while ($value instanceof JsonSerializable) {
            $value = $value->jsonSerialize();
        }

        return $value;
    }
}
