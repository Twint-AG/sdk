<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Value;

use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use Twint\Sdk\Value\QrCode;

/**
 * @template-extends ValueTest<QrCode>
 * @internal
 */
#[CoversClass(QrCode::class)]
final class QrCodeTest extends ValueTest
{
    private const IMAGE = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNk+A8AAQUBAScY42YAAAAASUVORK5CYII=';

    #[Override]
    protected function createValue(): object
    {
        return new QrCode(self::IMAGE);
    }

    #[Override]
    protected static function getValueType(): string
    {
        return QrCode::class;
    }

    public function testAsBinary(): void
    {
        $qrCode = new QrCode(self::IMAGE);

        self::assertStringContainsString('PNG', $qrCode->binary());
    }
}
