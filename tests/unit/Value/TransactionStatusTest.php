<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Value;

use PHPUnit\Framework\Attributes\CoversClass;
use Twint\Sdk\Value\TransactionStatus;

/**
 * @template-extends ValueTest<TransactionStatus>
 */
#[CoversClass(TransactionStatus::class)]
final class TransactionStatusTest extends ValueTest
{
    protected function createValue(): object
    {
        return TransactionStatus::GENERAL_ERROR();
    }

    protected static function getValueType(): string
    {
        return TransactionStatus::class;
    }
}
