<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Value;

use PHPUnit\Framework\Attributes\CoversClass;
use Twint\Sdk\Value\Url;

/**
 * @template-extends ValueTest<Url>
 */
#[CoversClass(Url::class)]
final class UrlTest extends ValueTest
{
    public function testCreateUrlThatIsNotValid(): void
    {
        $this->expectExceptionMessageMatches('/URL ".+" is not valid/');
        new Url('not-a-url');
    }

    protected function createValue(): object
    {
        return new Url('https://example.com');
    }

    protected static function getValueType(): string
    {
        return Url::class;
    }
}
