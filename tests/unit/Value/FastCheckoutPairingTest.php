<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Value;

use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use Twint\Sdk\Value\AlphanumericPairingToken;
use Twint\Sdk\Value\InteractiveFastCheckoutCheckIn;
use Twint\Sdk\Value\PairingStatus;
use Twint\Sdk\Value\PairingUuid;
use Twint\Sdk\Value\QrCode;

/**
 * @template-extends ValueTest<InteractiveFastCheckoutCheckIn>
 * @internal
 */
#[CoversClass(InteractiveFastCheckoutCheckIn::class)]
final class FastCheckoutPairingTest extends ValueTest
{
    private const IMAGE = 'data:image/png;base64,123';

    #[Override]
    protected function createValue(): object
    {
        return new InteractiveFastCheckoutCheckIn(
            PairingUuid::fromString('00000000-0000-0000-0000-000000000000'),
            new PairingStatus(PairingStatus::PAIRING_ACTIVE),
            new AlphanumericPairingToken('token'),
            new QrCode(self::IMAGE)
        );
    }

    #[Override]
    protected static function getValueType(): string
    {
        return InteractiveFastCheckoutCheckIn::class;
    }

    public function testAccessors(): void
    {
        $pairing = new InteractiveFastCheckoutCheckIn(
            PairingUuid::fromString('00000000-0000-0000-0000-000000000000'),
            new PairingStatus(PairingStatus::PAIRING_ACTIVE),
            new AlphanumericPairingToken('token'),
            new QrCode(self::IMAGE)
        );

        self::assertObjectEquals(
            PairingUuid::fromString('00000000-0000-0000-0000-000000000000'),
            $pairing->pairingUuid()
        );
        self::assertObjectEquals(new QrCode(self::IMAGE), $pairing->qrCode());
        self::assertObjectEquals(new AlphanumericPairingToken('token'), $pairing->pairingToken());
        self::assertTrue($pairing->isPaired());
        self::assertObjectEquals(new PairingStatus(PairingStatus::PAIRING_ACTIVE), $pairing->pairingStatus());
    }
}
