<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Value;

use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use Twint\Sdk\Value\Url;

/**
 * @template-extends ValueTest<Url>
 * @internal
 */
#[CoversClass(Url::class)]
final class UrlTest extends ValueTest
{
    public function testCreateUrlThatIsNotValid(): void
    {
        $this->expectExceptionMessageMatches('/URL ".+" is not valid/');
        new Url('not-a-url');
    }

    public function testWithQueryParameterAppendsToUrlWithoutExistingQuery(): void
    {
        $url = new Url('https://example.com/path');
        $result = $url->withQueryParameter('key', 'value');

        self::assertSame('https://example.com/path?key=value', (string) $result);
    }

    public function testWithQueryParameterAppendsToUrlWithExistingQuery(): void
    {
        $url = new Url('https://example.com/path?existing=1');
        $result = $url->withQueryParameter('key', 'value');

        self::assertSame('https://example.com/path?existing=1&key=value', (string) $result);
    }

    public function testWithQueryParameterEncodesNameAndValue(): void
    {
        $url = new Url('https://example.com');
        $result = $url->withQueryParameter('redirect url', 'https://example.com/callback?foo=bar&baz=1');

        self::assertSame(
            'https://example.com?redirect+url=https%3A%2F%2Fexample.com%2Fcallback%3Ffoo%3Dbar%26baz%3D1',
            (string) $result
        );
    }

    public function testWithQueryParameterReturnsNewInstance(): void
    {
        $url = new Url('https://example.com');
        $result = $url->withQueryParameter('key', 'value');

        self::assertNotSame($url, $result);
        self::assertSame('https://example.com', (string) $url);
    }

    public function testWithQueryParameterCanBeChained(): void
    {
        $url = new Url('https://example.com');
        $result = $url
            ->withQueryParameter('first', '1')
            ->withQueryParameter('second', '2');

        self::assertSame('https://example.com?first=1&second=2', (string) $result);
    }

    #[Override]
    protected function createValue(): object
    {
        return new Url('https://example.com');
    }

    #[Override]
    protected static function getValueType(): string
    {
        return Url::class;
    }
}
