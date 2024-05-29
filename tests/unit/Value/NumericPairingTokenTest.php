<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Value;

use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use Twint\Sdk\Value\NumericPairingToken;

/**
 * @template-extends ValueTest<NumericPairingToken>
 * @internal
 */
#[CoversClass(NumericPairingToken::class)]
final class NumericPairingTokenTest extends ValueTest
{
    private const TOKEN_VALUE = 123;

    #[Override]
    protected function createValue(): object
    {
        return new NumericPairingToken(self::TOKEN_VALUE);
    }

    #[Override]
    protected static function getValueType(): string
    {
        return NumericPairingToken::class;
    }

    public function testAccessPairingToken(): void
    {
        self::assertSame(self::TOKEN_VALUE, $this->value->token());
    }

    public function testFromString(): void
    {
        $token = NumericPairingToken::fromString((string) self::TOKEN_VALUE);

        self::assertObjectEquals(new NumericPairingToken(self::TOKEN_VALUE), $token);
    }
}
