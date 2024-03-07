<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Value;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Twint\Sdk\Value\Uuid;

/**
 * @covers \Twint\Sdk\Value\Uuid
 */
final class UuidTest extends TestCase
{
    private const UUID = '123e4567-e89b-12d3-a456-426614174000';

    /**
     * @return iterable<array{string}>
     */
    public static function unusualUuids(): iterable
    {
        yield ['urn:' . self::UUID];
        yield ['{' . self::UUID . '}'];
        yield ['uuid:' . self::UUID];
    }

    /**
     * @dataProvider unusualUuids
     */
    public function testValidationOfUnusualUuid(string $uuid): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('has to be 36 exactly characters long');
        new Uuid($uuid);
    }

    public function testInstantiateValidUuid(): void
    {
        $uuid = new Uuid(self::UUID);
        self::assertSame(self::UUID, (string) $uuid);
    }

    public function testNormalizesUuidToLowercase(): void
    {
        $uuid = new Uuid(strtolower(self::UUID));
        self::assertSame(self::UUID, (string) $uuid);
    }
}
