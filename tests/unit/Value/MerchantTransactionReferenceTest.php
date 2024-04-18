<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Value;

use PHPUnit\Framework\Attributes\CoversClass;
use Twint\Sdk\Value\FiledMerchantTransactionReference;
use Twint\Sdk\Value\MerchantTransactionReference;
use Twint\Sdk\Value\UnfiledMerchantTransactionReference;

/**
 * @template-extends ValueTest<UnfiledMerchantTransactionReference>
 * @internal
 */
#[CoversClass(MerchantTransactionReference::class)]
final class MerchantTransactionReferenceTest extends ValueTest
{
    public function testCreateUnfiledTransactionReferenceThatIsTooLong(): void
    {
        $this->expectExceptionMessageMatches(
            '/Transaction reference ".+" is too long. Must be 50 characters or less, got \d+/'
        );
        new UnfiledMerchantTransactionReference(str_repeat('x', 51));
    }

    public function testCreateFiledTransactionReferenceThatIsTooLong(): void
    {
        $this->expectExceptionMessageMatches(
            '/Transaction reference ".+" is too long. Must be 50 characters or less, got \d+/'
        );
        new FiledMerchantTransactionReference(str_repeat('x', 51));
    }

    protected function createValue(): object
    {
        return new UnfiledMerchantTransactionReference('1234567890');
    }

    protected static function getValueType(): string
    {
        return UnfiledMerchantTransactionReference::class;
    }
}
