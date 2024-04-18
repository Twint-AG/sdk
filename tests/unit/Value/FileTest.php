<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Value;

use PHPUnit\Framework\Attributes\CoversClass;
use Twint\Sdk\Value\File;

/**
 * @template-extends ValueTest<File>
 * @internal
 */
#[CoversClass(File::class)]
final class FileTest extends ValueTest
{
    protected function createValue(): object
    {
        return new File(__FILE__);
    }

    protected static function getValueType(): string
    {
        return File::class;
    }
}
