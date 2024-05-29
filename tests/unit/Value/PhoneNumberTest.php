<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Value;

use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use Twint\Sdk\Value\PhoneNumber;

/**
 * @template-extends ValueTest<PhoneNumber>
 * @internal
 */
#[CoversClass(PhoneNumber::class)]
final class PhoneNumberTest extends ValueTest
{
    #[Override]
    protected function createValue(): object
    {
        return new PhoneNumber('1234567890');
    }

    #[Override]
    protected static function getValueType(): string
    {
        return PhoneNumber::class;
    }
}
