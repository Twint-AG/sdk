<?php

declare(strict_types=1);

namespace Twint\Sdk\Util;

final class HigherOrder
{
    /**
     * @template T
     * @param T $v
     * @return T
     */
    public static function identity(mixed $v): mixed
    {
        return $v;
    }

    /**
     * @template T
     * @param T $v
     * @return T
     */
    public static function dump(mixed $v): mixed
    {
        var_dump($v);

        return $v;
    }
}
