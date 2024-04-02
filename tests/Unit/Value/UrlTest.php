<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Value;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Twint\Sdk\Value\Url;

#[CoversClass(UrlTest::class)]
final class UrlTest extends TestCase
{
    public function testCreateUrlThatIsNotValid(): void
    {
        $this->expectExceptionMessageMatches('/URL ".+" is not valid/');
        new Url('not-a-url');
    }
}
