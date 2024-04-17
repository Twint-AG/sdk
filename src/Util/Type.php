<?php

declare(strict_types=1);

namespace Twint\Sdk\Util;

use Psl\Type\TypeInterface;
use function Psl\Type\literal_scalar;
use function Psl\Type\union;

final class Type
{
    /**
     * @template T
     * @param TypeInterface<T> ...$types
     * @return TypeInterface<T>
     */
    public static function maybeUnion(TypeInterface ...$types): TypeInterface
    {
        if (count($types) === 1) {
            return $types[0];
        }

        return union(...$types);
    }

    /**
     * @template T of bool|float|int|string
     * @param T ...$literals
     * @return TypeInterface<T>
     */
    public static function maybeUnionOfLiterals(bool|float|int|string ...$literals): TypeInterface
    {
        return self::maybeUnion(...array_map(static fn (bool|float|int|string $v) => literal_scalar($v), $literals));
    }
}
