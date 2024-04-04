<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Value;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Twint\Sdk\Value\FiledMerchantTransactionReference;
use Twint\Sdk\Value\MerchantTransactionReference;
use Twint\Sdk\Value\UnfiledMerchantTransactionReference;

#[CoversClass(MerchantTransactionReference::class)]
final class MerchantTransactionReferenceTest extends TestCase
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
}
