<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Value;

use PHPUnit\Framework\Attributes\CoversClass;
use Twint\Sdk\Value\PairingToken;

/**
 * @template-extends ValueTest<PairingToken>
 */
#[CoversClass(PairingToken::class)]
final class PairingTokenTest extends ValueTest
{
    private const TOKEN_VALUE = 123;

    protected function createValue(): object
    {
        return new PairingToken(self::TOKEN_VALUE);
    }

    protected static function getValueType(): string
    {
        return PairingToken::class;
    }

    public function testAccessPairingToken(): void
    {
        self::assertSame(self::TOKEN_VALUE, $this->value->token());
    }
}
