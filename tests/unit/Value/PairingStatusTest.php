<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Value;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Twint\Sdk\Value\PairingStatus;
use ValueError;

/**
 * @internal
 */
#[CoversClass(PairingStatus::class)]
final class PairingStatusTest extends TestCase
{
    public function testCreateFromInvalidString(): void
    {
        $this->expectException(ValueError::class);

        PairingStatus::from('invalid');
    }

    public function testCreateFromString(): void
    {
        self::assertSame(PairingStatus::PAIRING_IN_PROGRESS, PairingStatus::from('PAIRING_IN_PROGRESS'));
    }

    public function testJsonSerialize(): void
    {
        self::assertJsonStringEqualsJsonString(
            '"PAIRING_ACTIVE"',
            json_encode(PairingStatus::PAIRING_ACTIVE, JSON_THROW_ON_ERROR)
        );
    }
}
