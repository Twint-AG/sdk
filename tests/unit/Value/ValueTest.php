<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Value;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Twint\Sdk\Value\Comparable;
use Twint\Sdk\Value\Enum;
use Twint\Sdk\Value\Equality;
use function Psl\Type\string;

/**
 * @template T of (Comparable&Equality)|(Comparable&Enum&Equality)
 */
abstract class ValueTest extends TestCase
{
    /**
     * @var T
     */
    protected object $value;

    /**
     * @return iterable<string, array{string, string}>
     */
    public static function getValueConstants(): iterable
    {
        $class = new ReflectionClass(static::getValueType());

        if (!$class->implementsInterface(Enum::class)) {
            yield 'EMPTY' => ['', ''];
            return;
        }

        foreach ($class->getConstants() as $name => $value) {
            yield $name => [$name, string()->assert($value)];
        }
    }

    protected function setUp(): void
    {
        $this->value = $this->createValue();
    }

    /**
     * @return T
     */
    abstract protected function createValue(): object;

    /**
     * @return class-string
     */
    abstract protected static function getValueType(): string;

    public function testSimpleEquality(): void
    {
        self::assertTrue($this->value->equals($this->value));
    }

    public function testCompareSimpleValue(): void
    {
        self::assertSame(0, $this->value->compare($this->value));
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
            self::assertTrue($property->isReadOnly());
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
    public function testConstantNameAndValueMatches(string $constantName, string $constantValue): void
    {
        if (!$this->value instanceof Enum) {
            self::markTestSkipped('This test is only for Enum values');
        }

        self::assertSame($constantName, $constantValue);
    }

    #[DataProvider('getValueConstants')]
    public function testNamedConstructorExistsForEachPossibleValue(string $constantName): void
    {
        if (!$this->value instanceof Enum) {
            self::markTestSkipped('This test is only for Enum values');
        }

        $class = new ReflectionClass(static::getValueType());
        self::assertTrue($class->hasMethod($constantName));
        self::assertTrue($class->getMethod($constantName)->isStatic());
        self::assertTrue($class->getMethod($constantName)->isPublic());
    }

    #[DataProvider('getValueConstants')]
    public function testNamedConstructorCanBeUsedToInstantiateValue(string $constantName): void
    {
        if (!$this->value instanceof Enum) {
            self::markTestSkipped('This test is only for Enum values');
        }

        $class = new ReflectionClass(static::getValueType());
        if ($class->getMethod($constantName)->getNumberOfParameters() > 0) {
            self::markTestSkipped('Covers only named constructors with arity 0');
        }

        $value = (static::getValueType())::$constantName(); // @phpstan-ignore-line
        self::assertInstanceOf(static::getValueType(), $value);
    }
}
