<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Value;

use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use Twint\Sdk\Value\PaymentUrl;
use Twint\Sdk\Value\Url;

/**
 * @template-extends ValueTest<PaymentUrl>
 * @internal
 */
#[CoversClass(PaymentUrl::class)]
final class PaymentUrlTest extends ValueTest
{
    public function testWithSuccessUrl(): void
    {
        $paymentUrl = new PaymentUrl(new Url('https://twint.ch/pay'));
        $result = $paymentUrl->withSuccessUrl(new Url('https://shop.example.com/success'));

        self::assertSame(
            'https://twint.ch/pay?redirectURL=https%3A%2F%2Fshop.example.com%2Fsuccess',
            (string) $result
        );
    }

    public function testWithCancelUrl(): void
    {
        $paymentUrl = new PaymentUrl(new Url('https://twint.ch/pay'));
        $result = $paymentUrl->withCancelUrl(new Url('https://shop.example.com/cancel'));

        self::assertSame(
            'https://twint.ch/pay?cancelOrderCallbackURL=https%3A%2F%2Fshop.example.com%2Fcancel',
            (string) $result
        );
    }

    public function testWithSuccessUrlAndCancellationUrl(): void
    {
        $paymentUrl = new PaymentUrl(new Url('https://twint.ch/pay'));
        $result = $paymentUrl
            ->withSuccessUrl(new Url('https://shop.example.com/success'))
            ->withCancelUrl(new Url('https://shop.example.com/cancel'));

        self::assertSame(
            'https://twint.ch/pay?redirectURL=https%3A%2F%2Fshop.example.com%2Fsuccess&cancelOrderCallbackURL=https%3A%2F%2Fshop.example.com%2Fcancel',
            (string) $result
        );
    }

    public function testWithSuccessUrlReturnsNewInstance(): void
    {
        $paymentUrl = new PaymentUrl(new Url('https://twint.ch/pay'));
        $result = $paymentUrl->withSuccessUrl(new Url('https://shop.example.com/success'));

        self::assertNotSame($paymentUrl, $result);
        self::assertSame('https://twint.ch/pay', (string) $paymentUrl);
    }

    public function testWithCancelUrlReturnsNewInstance(): void
    {
        $paymentUrl = new PaymentUrl(new Url('https://twint.ch/pay'));
        $result = $paymentUrl->withCancelUrl(new Url('https://shop.example.com/cancel'));

        self::assertNotSame($paymentUrl, $result);
        self::assertSame('https://twint.ch/pay', (string) $paymentUrl);
    }

    public function testWithSuccessUrlPreservesExistingQueryParameters(): void
    {
        $paymentUrl = new PaymentUrl(new Url('https://twint.ch/pay?token=abc'));
        $result = $paymentUrl->withSuccessUrl(new Url('https://shop.example.com/success'));

        self::assertSame(
            'https://twint.ch/pay?token=abc&redirectURL=https%3A%2F%2Fshop.example.com%2Fsuccess',
            (string) $result
        );
    }

    #[Override]
    protected function createValue(): object
    {
        return new PaymentUrl(new Url('https://twint.ch/pay'));
    }

    #[Override]
    protected static function getValueType(): string
    {
        return PaymentUrl::class;
    }
}
