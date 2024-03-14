<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Value;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Twint\Sdk\Value\Url;

/** @covers \Twint\Sdk\Value\Url */
final class UrlTest extends TestCase
{
    public function testCreateUrlThatIsNotValid(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/URL ".+" is not valid/');
        new Url('not-a-url');
    }
}
