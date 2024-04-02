<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Value;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Twint\Sdk\Value\TransactionReference;

#[CoversClass(TransactionReference::class)]
final class TransactionReferenceTest extends TestCase
{
    public function testCreateTransactionReferenceThatIsTooLong(): void
    {
        $this->expectExceptionMessageMatches(
            '/Transaction reference ".+" is too long. Must be 50 characters or less, got \d+/'
        );
        new TransactionReference(str_repeat('x', 51));
    }
}
