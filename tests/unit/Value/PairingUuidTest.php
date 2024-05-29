<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Value;

use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use Twint\Sdk\Value\PairingUuid;
use Twint\Sdk\Value\Uuid;

/**
 * @template-extends ValueTest<PairingUuid>
 * @internal
 */
#[CoversClass(PairingUuid::class)]
final class PairingUuidTest extends ValueTest
{
    #[Override]
    protected function createValue(): object
    {
        return new PairingUuid(new Uuid('00000000-0000-0000-0000-000000000000'));
    }

    #[Override]
    protected static function getValueType(): string
    {
        return PairingUuid::class;
    }

    public function testFromString(): void
    {
        $uuid = PairingUuid::fromString('00000000-0000-0000-0000-000000000000');

        self::assertObjectEquals(new PairingUuid(new Uuid('00000000-0000-0000-0000-000000000000')), $uuid);
    }
}
