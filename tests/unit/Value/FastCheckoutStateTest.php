<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Value;

use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use Twint\Sdk\Value\CustomerData;
use Twint\Sdk\Value\Email;
use Twint\Sdk\Value\FastCheckoutCheckIn;
use Twint\Sdk\Value\PairingStatus;
use Twint\Sdk\Value\PairingUuid;
use Twint\Sdk\Value\ShippingMethodId;

/**
 * @template-extends ValueTest<FastCheckoutCheckIn>
 * @internal
 */
#[CoversClass(FastCheckoutCheckIn::class)]
final class FastCheckoutStateTest extends ValueTest
{
    #[Override]
    protected function createValue(): object
    {
        return new FastCheckoutCheckIn(
            PairingUuid::fromString('00000000-0000-0000-0000-000000000000'),
            new PairingStatus(PairingStatus::NO_PAIRING),
            null,
            null,
        );
    }

    #[Override]
    protected static function getValueType(): string
    {
        return FastCheckoutCheckIn::class;
    }

    public function testAccessors(): void
    {
        $pairing = new FastCheckoutCheckIn(
            PairingUuid::fromString('00000000-0000-0000-0000-000000000000'),
            new PairingStatus(PairingStatus::PAIRING_ACTIVE),
            new ShippingMethodId('shipping_method_id'),
            new CustomerData([
                'email' => new Email('foo@host.com'),
            ])
        );

        self::assertObjectEquals(
            PairingUuid::fromString('00000000-0000-0000-0000-000000000000'),
            $pairing->pairingUuid()
        );
        self::assertTrue($pairing->isPaired());
        self::assertObjectEquals(new PairingStatus(PairingStatus::PAIRING_ACTIVE), $pairing->pairingStatus());

        self::assertTrue($pairing->hasShippingMethodId());
        self::assertObjectEquals(new ShippingMethodId('shipping_method_id'), $pairing->shippingMethodId());

        self::assertTrue($pairing->hasCustomerData());
        self::assertObjectEquals(
            new CustomerData([
                'email' => new Email('foo@host.com'),
            ]),
            $pairing->customerData()
        );
    }
}
