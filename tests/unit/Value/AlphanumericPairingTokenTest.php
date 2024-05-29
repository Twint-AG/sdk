<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Value;

use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use Psl\Type\Exception\AssertException;
use Twint\Sdk\Value\AlphanumericPairingToken;

/**
 * @template-extends ValueTest<AlphanumericPairingToken>
 * @internal
 */
#[CoversClass(AlphanumericPairingToken::class)]
final class AlphanumericPairingTokenTest extends ValueTest
{
    private const TOKEN_VALUE = 'A123';

    #[Override]
    protected function createValue(): object
    {
        return new AlphanumericPairingToken(self::TOKEN_VALUE);
    }

    #[Override]
    protected static function getValueType(): string
    {
        return AlphanumericPairingToken::class;
    }

    public function testAccessPairingToken(): void
    {
        self::assertSame(self::TOKEN_VALUE, $this->value->token());
    }

    public function testFromString(): void
    {
        $this->expectException(AssertException::class);

        AlphanumericPairingToken::fromString('');
    }
}
