<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Value;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Twint\Sdk\Value\MerchantTransactionReference;

#[CoversClass(MerchantTransactionReference::class)]
final class MerchantTransactionReferenceTest extends TestCase
{
    public function testCreateTransactionReferenceThatIsTooLong(): void
    {
        $this->expectExceptionMessageMatches(
            '/Transaction reference ".+" is too long. Must be 50 characters or less, got \d+/'
        );
        new MerchantTransactionReference(str_repeat('x', 51));
    }
}
