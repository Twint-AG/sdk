<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Value;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Twint\Sdk\Value\TransactionReference;

/** @covers \Twint\Sdk\Value\TransactionReference */
final class TransactionReferenceTest extends TestCase
{
    public function testCreateTransactionReferenceThatIsTooLong(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageMatches(
            '/Transaction reference ".+" is too long. Must be 50 characters or less, got \d+/'
        );
        new TransactionReference(str_repeat('x', 51));
    }
}
