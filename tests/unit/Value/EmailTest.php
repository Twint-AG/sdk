<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Value;

use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use Twint\Sdk\Value\Email;

/**
 * @template-extends ValueTest<Email>
 * @internal
 */
#[CoversClass(Email::class)]
final class EmailTest extends ValueTest
{
    #[Override]
    protected function createValue(): object
    {
        return new Email('foo@host.com');
    }

    #[Override]
    protected static function getValueType(): string
    {
        return Email::class;
    }
}
