<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Value;

use PHPUnit\Framework\Attributes\CoversClass;
use Twint\Sdk\Value\IosAppScheme;

/**
 * @template-extends ValueTest<IosAppScheme>
 * @internal
 */
#[CoversClass(IosAppScheme::class)]
final class IosAppSchemeTest extends ValueTest
{
    private const DISPLAY_NAME = 'Display Name Issuer 123';

    private const ISSUER = 'twint-issuer123://';

    protected function createValue(): object
    {
        return new IosAppScheme(self::ISSUER, self::DISPLAY_NAME);
    }

    protected static function getValueType(): string
    {
        return IosAppScheme::class;
    }

    public function testAccessSchemeAndDisplayName(): void
    {
        $iosAppScheme = $this->createValue();

        self::assertSame(self::ISSUER, $iosAppScheme->scheme());
        self::assertSame(self::DISPLAY_NAME, $iosAppScheme->displayName());
    }
}
