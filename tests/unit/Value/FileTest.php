<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Value;

use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use Twint\Sdk\Value\ExistingPath;

/**
 * @template-extends ValueTest<ExistingPath>
 * @internal
 */
#[CoversClass(ExistingPath::class)]
final class FileTest extends ValueTest
{
    #[Override]
    protected function createValue(): object
    {
        return new ExistingPath(__FILE__);
    }

    #[Override]
    protected static function getValueType(): string
    {
        return ExistingPath::class;
    }
}
