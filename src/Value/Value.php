<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use JsonSerializable;

/**
 * @template T of Equality
 * @template-extends Comparable<T>
 * @template-extends Equality<T>
 */
interface Value extends Comparable, Equality, JsonSerializable
{
}
