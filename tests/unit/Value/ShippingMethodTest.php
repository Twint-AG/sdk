<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Value;

use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use Psl\Exception\InvariantViolationException;
use Twint\Sdk\Util\ShippingLabelTransliterator;
use Twint\Sdk\Value\Money;
use Twint\Sdk\Value\ShippingMethod;
use Twint\Sdk\Value\ShippingMethodId;

/**
 * @template-extends ValueTest<ShippingMethod>
 * @internal
 */
#[CoversClass(ShippingMethod::class)]
#[CoversClass(ShippingLabelTransliterator::class)]
final class ShippingMethodTest extends ValueTest
{
    /**
     * @return iterable<array{0: non-empty-string}>
     */
    public static function getRejectsInvalidLabelCases(): iterable
    {
        yield 'exceeds max length' => [str_repeat('🌟', 1001)];
    }

    /**
     * @return iterable<array{0: non-empty-string, 1: non-empty-string}>
     */
    public static function getTransliteratesLabelCases(): iterable
    {
        yield 'max length with multi-byte chars' => [
            str_repeat('ä', 128) . str_repeat('é', 127),
            str_repeat('ä', 128) . str_repeat('é', 127),
        ];
        yield 'simple string' => ['Standard Shipping', 'Standard Shipping'];
        yield 'multi-byte chars' => ['Äé', 'Äé'];
        yield 'multi-byte chars with special chars' => ['äé!', 'äé!'];
        yield 'emoji' => ['String with 🌟', 'String with {GLOWING STAR}'];
        yield 'real case 1' => [
            'Kostenloser Versand (Voraussichtlicher Liefertermin: 3.⁠–6. Dez)',
            'Kostenloser Versand (Voraussichtlicher Liefertermin: 3.–6. Dez)',
        ];
    }

    #[Override]
    protected function createValue(): object
    {
        return new ShippingMethod(new ShippingMethodId('123'), 'name', Money::CHF(10.00));
    }

    #[Override]
    protected static function getValueType(): string
    {
        return ShippingMethod::class;
    }

    #[DataProvider('getRejectsInvalidLabelCases')]
    public function testRejectsInvalidLabel(string $label): void
    {
        $this->expectException(InvariantViolationException::class);

        // @phpstan-ignore-next-line argument.type
        new ShippingMethod(new ShippingMethodId('123'), $label, Money::CHF(10.00));
    }

    /**
     * @param non-empty-string $label
     * @param non-empty-string $expected
     */
    #[DataProvider('getTransliteratesLabelCases')]
    public function testTransliteratesLabel(string $label, string $expected): void
    {
        $method = new ShippingMethod(new ShippingMethodId('123'), $label, Money::CHF(10.00));

        self::assertSame($expected, $method->label());
    }
}
