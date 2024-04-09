<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Value;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Psl\Exception\InvariantViolationException;
use Twint\Sdk\Value\Uuid;

#[CoversClass(Uuid::class)]
final class UuidTest extends TestCase
{
    private const UUID = '123e4567-e89b-12d3-a456-426614174000';

    /**
     * @return iterable<array-key, array{string}>
     */
    public static function unusualUuids(): iterable
    {
        yield ['urn:' . self::UUID];
        yield ['{' . self::UUID . '}'];
        yield ['uuid:' . self::UUID];
    }

    #[DataProvider('unusualUuids')]
    public function testValidationOfUnusualUuid(string $uuid): void
    {
        $this->expectException(InvariantViolationException::class);
        $this->expectExceptionMessageMatches('/Invalid UUID ".+". Must be in the format "8-4-4-4-12"/');
        new Uuid($uuid);
    }

    public function testInstantiateValidUuid(): void
    {
        $uuid = new Uuid(self::UUID);
        self::assertSame(self::UUID, (string) $uuid);
    }

    public function testNormalizesUuidToLowercase(): void
    {
        $uuid = new Uuid(strtoupper(self::UUID));
        self::assertSame(self::UUID, (string) $uuid);
    }
}
