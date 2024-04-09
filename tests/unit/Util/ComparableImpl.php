<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Util;

use Twint\Sdk\Value\Comparable;
use function Psl\Type\instance_of;

/**
 * @template-implements Comparable<self>
 */
final class ComparableImpl implements Comparable
{
    public function __construct(
        private readonly mixed $value,
    ) {
    }

    public function compare($other): int
    {
        instance_of(self::class)->assert($other);

        return $this->value <=> $other->value;
    }
}
