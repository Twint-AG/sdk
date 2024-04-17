<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Value;

use PHPUnit\Framework\Attributes\CoversClass;
use Psl\Type\Exception\AssertException;
use Twint\Sdk\Value\PairingStatus;

/**
 * @template-extends ValueTest<PairingStatus>
 */
#[CoversClass(PairingStatus::class)]
final class PairingStatusTest extends ValueTest
{
    protected function createValue(): object
    {
        return PairingStatus::NO_PAIRING();
    }

    protected static function getValueType(): string
    {
        return PairingStatus::class;
    }

    public function testCreateFromInvalidString(): void
    {
        $this->expectException(AssertException::class);

        PairingStatus::fromString('invalid');
    }

    public function testCreateFromString(): void
    {
        $pairingStatus = PairingStatus::fromString(PairingStatus::PAIRING_IN_PROGRESS);

        self::assertObjectEquals(PairingStatus::PAIRING_IN_PROGRESS(), $pairingStatus);
    }
}
