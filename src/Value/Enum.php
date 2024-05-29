<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use Stringable;

/**
 * @template T
 * @template-extends FixedValues<T>
 */
interface Enum extends FixedValues, Stringable
{
}
