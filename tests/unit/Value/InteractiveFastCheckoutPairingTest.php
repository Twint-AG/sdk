<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Value;

use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use Twint\Sdk\Value\AlphanumericPairingToken;
use Twint\Sdk\Value\InteractiveFastCheckoutCheckIn;
use Twint\Sdk\Value\PairingStatus;
use Twint\Sdk\Value\PairingUuid;
use Twint\Sdk\Value\PaymentUrl;
use Twint\Sdk\Value\QrCode;
use Twint\Sdk\Value\Url;

/**
 * @template-extends ValueTest<InteractiveFastCheckoutCheckIn<QrCode, PaymentUrl>>
 * @internal
 */
#[CoversClass(InteractiveFastCheckoutCheckIn::class)]
final class InteractiveFastCheckoutPairingTest extends ValueTest
{
    private const IMAGE = 'data:image/png;base64,123';

    private const PAYMENT_URL = 'https://example.org';

    #[Override]
    protected function createValue(): object
    {
        return new InteractiveFastCheckoutCheckIn(
            PairingUuid::fromString('00000000-0000-0000-0000-000000000000'),
            PairingStatus::PAIRING_ACTIVE,
            new AlphanumericPairingToken('token'),
            new QrCode(self::IMAGE),
            new PaymentUrl(new Url(self::PAYMENT_URL)),
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
            PairingStatus::PAIRING_ACTIVE,
            new AlphanumericPairingToken('token'),
            new QrCode(self::IMAGE),
            null,
        );

        self::assertObjectEquals(
            PairingUuid::fromString('00000000-0000-0000-0000-000000000000'),
            $pairing->pairingUuid()
        );
        self::assertObjectEquals(new QrCode(self::IMAGE), $pairing->qrCode());
        self::assertNull($pairing->paymentUrl());
        self::assertObjectEquals(new AlphanumericPairingToken('token'), $pairing->pairingToken());
        self::assertTrue($pairing->isPaired());
        self::assertSame(PairingStatus::PAIRING_ACTIVE, $pairing->pairingStatus());
    }

    public function testAccessPaymentUrl(): void
    {
        $pairing = new InteractiveFastCheckoutCheckIn(
            PairingUuid::fromString('00000000-0000-0000-0000-000000000000'),
            PairingStatus::PAIRING_ACTIVE,
            new AlphanumericPairingToken('token'),
            null,
            new PaymentUrl(new Url('https://twint.ch')),
        );

        self::assertObjectEquals(
            PairingUuid::fromString('00000000-0000-0000-0000-000000000000'),
            $pairing->pairingUuid()
        );
        self::assertNull($pairing->qrCode());
        self::assertObjectEquals(new PaymentUrl(new Url('https://twint.ch')), $pairing->paymentUrl());
        self::assertObjectEquals(new AlphanumericPairingToken('token'), $pairing->pairingToken());
        self::assertTrue($pairing->isPaired());
        self::assertSame(PairingStatus::PAIRING_ACTIVE, $pairing->pairingStatus());
    }
}
