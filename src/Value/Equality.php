<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

/**
 * @template T of object
 */
interface Equality
{
    /**
     * @param T $other
     */
    public function equals($other): bool;
}
