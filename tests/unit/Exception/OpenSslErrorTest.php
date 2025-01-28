<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Exception;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Twint\Sdk\Exception\OpenSslError;

/**
 * @internal
 */
#[CoversClass(OpenSslError::class)]
final class OpenSslErrorTest extends TestCase
{
    public function testConstructor(): void
    {
        $error = new OpenSslError('Test message', '123', null, 'SSL', 'verify');

        self::assertSame('Test message', $error->getMessage());
        self::assertSame('123', $error->getCode());
        self::assertSame('SSL', $error->getLibrary());
        self::assertSame('verify', $error->getFunction());
    }

    public function testFromErrorsSingle(): void
    {
        $error = OpenSslError::fromErrors(['error:0906D06C:PEM routines:PEM_read_bio:no start line']);

        self::assertInstanceOf(OpenSslError::class, $error);
        self::assertStringContainsString('PEM routines', $error->getMessage());
        self::assertSame('0906D06C', $error->getCode());
        self::assertSame('PEM routines', $error->getLibrary());
        self::assertSame('PEM_read_bio', $error->getFunction());
    }

    public function testFromErrorsMultiple(): void
    {
        $error = OpenSslError::fromErrors([
            'error:0906D06C:PEM routines:PEM_read_bio:no start line',
            'error:1234ABCD:SSL:verify_callback:certificate verify failed',
        ]);

        self::assertInstanceOf(OpenSslError::class, $error);
        self::assertStringContainsString('no start line', $error->getMessage());
        self::assertSame('0906D06C', $error->getCode());
        self::assertSame('PEM routines', $error->getLibrary());
        self::assertSame('PEM_read_bio', $error->getFunction());

        $previous = $error->getPrevious();
        self::assertInstanceOf(OpenSslError::class, $previous);
        self::assertStringContainsString('certificate verify failed', $previous->getMessage());
        self::assertSame('1234ABCD', $previous->getCode());
        self::assertSame('SSL', $previous->getLibrary());
        self::assertSame('verify_callback', $previous->getFunction());

        self::assertNull($previous->getPrevious());
    }

    public function testFromErrorsInvalidFormat(): void
    {
        $error = OpenSslError::fromErrors(['Invalid OpenSSL error format']);

        self::assertInstanceOf(OpenSslError::class, $error);
        self::assertSame('Invalid OpenSSL error format', $error->getMessage());
        self::assertSame('0', $error->getCode());
        self::assertNull($error->getLibrary());
        self::assertNull($error->getFunction());
    }

    public function testFromErrorsEmpty(): void
    {
        self::assertNull(OpenSslError::fromErrors([]));
    }
}
