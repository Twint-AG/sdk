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
    #[Override]
    protected function createValue(): object
    {
        return new QrCode('data:image/png;base64,123');
    }

    #[Override]
    protected static function getValueType(): string
    {
        return QrCode::class;
    }
}