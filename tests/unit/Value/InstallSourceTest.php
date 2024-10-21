<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Value;

use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use Twint\Sdk\Value\InstallSource;

/**
 * @template-extends ValueTest<InstallSource>
 * @internal
 */
#[CoversClass(InstallSource::class)]
final class InstallSourceTest extends ValueTest
{
    protected bool $constNamesEqualsValues = false;

    #[Override]
    protected function createValue(): object
    {
        return new InstallSource(InstallSource::DIRECT);
    }

    #[Override]
    protected static function getValueType(): string
    {
        return InstallSource::class;
    }
}
